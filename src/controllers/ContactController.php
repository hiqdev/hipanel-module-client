<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\actions\ContactCreateAction;
use hipanel\modules\client\actions\ContactUpdateAction;
use hipanel\modules\client\forms\EmployeeForm;
use hipanel\modules\client\forms\PhoneConfirmationForm;
use hipanel\modules\client\helpers\HasPINCode;
use hipanel\modules\client\logic\EmailConfirmer;
use hipanel\modules\client\logic\PhoneConfirmationException;
use hipanel\modules\client\logic\PhoneConfirmer;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\query\ContactQuery;
use hipanel\modules\client\models\Verification;
use hipanel\modules\client\repositories\NotifyTriesRepository;
use hipanel\modules\document\models\Document;
use Yii;
use yii\base\Event;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ContactController extends CrudController
{
    /**
     * @var NotifyTriesRepository
     */
    private $notifyTriesRepository;
    /**
     * @var HasPINCode
     */
    private $hasPINCode;

    public function __construct($id, $module, NotifyTriesRepository $notifyTriesRepository, HasPINCode $hasPINCode, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->notifyTriesRepository = $notifyTriesRepository;
        $this->hasPINCode = $hasPINCode;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'create' => 'contact.create',
                    'update' => 'contact.update',
                    'delete' => 'contact.delete',
                    'update-employee' => 'employee.update',
                    'set-confirmation' => 'contact.force-verify',
                    'confirm-email' => true,
                    'reserve-number' => 'requisites.update',
                    '*' => 'contact.read',
                ],
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'set-confirmation' => ['post'],
                    'request-email-verification' => ['post'],
                    'request-phone-confirmation-code' => ['post'],
                    'confirm-phone' => ['post'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => ['with_counters' => 1],
                'on beforePerform' => function ($event) {
                    /** @var ViewAction $action */
                    $action = $event->sender;

                    /** @var ContactQuery $query */
                    $query = $action->getDataProvider()->query;

                    if (Yii::getAlias('@document', false)) {
                        $query->withDocuments();
                    }
                    $query->withLocalizations();
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'validate-single-form' => [
                'class' => ValidateFormAction::class,
                'validatedInputId' => false,
            ],
            'create' => [
                'class' => ContactCreateAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', 'Contact was deleted'),
            ],
            'update' => [
                'class' => ContactUpdateAction::class,
            ],
            'copy' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'create',
                'data' => function ($action) {
                    return [
                        'countries' => $action->controller->getRefs('country_code'),
                        'action' => 'create',
                    ];
                },
            ],
            'set-confirmation' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'set-confirmation',
                'collection' => [
                    'model' => Verification::class,
                ],
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\Action $action */
                    $action = $event->sender;

                    $type = Yii::$app->request->post('type');
                    foreach ($action->collection->models as $model) {
                        $model->type = $type;
                    }
                },
            ],
            'request-email-confirmation' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Confirmation message was sent to your email'),
            ],
            'reserve-number' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Document number was reserved'),
            ],
        ]);
    }

    public function actionAttachDocuments($id)
    {
        $contact = Contact::findOne($id);

        if ($contact === null) {
            throw new NotFoundHttpException();
        }

        $model = new Document([
            'client_id' => $contact->client_id,
            'client' => $contact->client,
            'sender_id' => $contact->id,
            'object_id' => $contact->id,
            'scenario' => 'create',
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $session = Yii::$app->session;
            try {
                if (!$model->save()) {
                    throw new \RuntimeException(Yii::t('hipanel:client', 'Document could not be saved'));
                }
                Contact::perform('attach-document', array_merge($model->getAttributes(), [
                    'id' => $contact->id,
                    'file_id' => $model->file->id,
                ]));

                $session->addFlash('success', Yii::t('hipanel:client', 'Documents were saved'));

                return $this->redirect(['attach-documents', 'id' => $id]);
            } catch (\Throwable $e) {
                $session->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('attach-documents', [
            'contact' => $contact,
            'model' => $model,
        ]);
    }

    public function actionPhoneConfirmationModal($id, $type)
    {
        $contact = $this->getContactById($id);
        $tries = $this->getTriesForContact($contact, $type);
        $model = PhoneConfirmationForm::fromContact($contact, $type);
        $model->scenario = 'check';

        return $this->renderAjax('confirmationModal', [
            'model' => $model,
            'contact' => $contact,
            'tries' => $tries,
        ]);
    }

    public function actionConfirmPhone($id, $type)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $contact = $this->getContactById($id);

        $model = new PhoneConfirmationForm(['scenario' => 'check', 'type' => $type]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $tries = $this->getTriesForContact($contact, $model->type);

            /** @var PhoneConfirmer $confirmer */
            $confirmer = Yii::createObject(PhoneConfirmer::class, [$model, $tries]);

            try {
                $confirmer->submitCode();

                return ['success' => Yii::t('hipanel:client', 'The phone number was verified successfully')];
            } catch (PhoneConfirmationException $e) {
                return ['error' => $e->getMessage()];
            }
        }

        return ['error' => true];
    }

    public function actionRequestPhoneConfirmationCode()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new PhoneConfirmationForm(['scenario' => 'request']);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $contact = $this->getContactById($model->id);
            $tries = $this->getTriesForContact($contact, $model->type);

            /** @var PhoneConfirmer $confirmer */
            $confirmer = Yii::createObject(PhoneConfirmer::class, [$model, $tries]);
            try {
                $confirmer->requestCode();

                return [
                    'success' => true,
                    'message' => Yii::t('hipanel:client', 'Code was sent successfully'),
                ];
            } catch (PhoneConfirmationException $e) {
                return ['error' => $e->getMessage()];
            }
        }

        return ['error' => true];
    }

    public function actionConfirmEmail($id = null)
    {
        $confirmer = Yii::createObject(EmailConfirmer::class);
        $confirm = $confirmer->confirm();
        if ($confirm['success']) {
            Yii::$app->getSession()->setFlash('success', Yii::t('hipanel:client', 'Email was confirmed successfully'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('hipanel:client', 'Error happened during email confirmation'));
        }

        $to = $id ? ['@contact/view', 'id' => $id] : ['/site/profile'];

        return $this->redirect($to);
    }

    private function getContactById($id)
    {
        $contact = Contact::find()->where(['id' => $id])->one();
        if ($contact === null) {
            throw new NotFoundHttpException('Contact was not found');
        }

        return $contact;
    }

    private function getTriesForContact($contact, $type)
    {
        $tries = $this->notifyTriesRepository->getTriesForContact($contact, $type);
        if ($tries === null) {
            throw new NotFoundHttpException('Tries information for contact was not found');
        }

        return $tries;
    }

    public function actionUpdateEmployee($id)
    {
        $contact = Contact::find()
            ->where(['id' => $id])
            ->withDocuments()
            ->withLocalizations()
            ->one();

        if ($contact === null) {
            throw new NotFoundHttpException('Contact was not found');
        }

        $model = new EmployeeForm($contact, 'update');
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
                Yii::$app->session->addFlash('success', Yii::t('hipanel:client', 'Employee contact was save successfully'));
                return $this->redirect(['@client/view', 'id' => $model->getId()]);
            }

            $errors = $model->getFirstErrors();
            Yii::$app->session->addFlash('error', implode("\n", $errors));
        }

        return $this->render('update-employee', [
            'employeeForm' => $model,
            'model' => $model->getPrimaryContact(),
            'askPincode' => $this->hasPINCode->__invoke(),
            'countries' => $this->getRefs('country_code'),
        ]);
    }

    public function actionShortView($id)
    {
        $contact = Contact::find()
            ->where(['id' => $id])
            ->one();

        if ($contact === null) {
            throw new NotFoundHttpException('Contact was not found');
        }

        return Yii::$app->request->isAjax
            ? $this->renderPartial('short-view', ['model' => $contact])
            : $this->render('short-view', ['model' => $contact])
        ;
    }
}
