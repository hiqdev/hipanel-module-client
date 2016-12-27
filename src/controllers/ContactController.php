<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\helpers\ArrayHelper;
use hipanel\modules\client\forms\PhoneConfirmationForm;
use hipanel\modules\client\logic\PhoneConfirmationException;
use hipanel\modules\client\logic\PhoneConfirmer;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\DocumentUploadForm;
use hipanel\modules\client\models\Verification;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\repositories\NotifyTriesRepository;
use Yii;
use yii\base\Event;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ContactController extends CrudController
{
    /**
     * @var NotifyTriesRepository
     */
    private $notifyTriesRepository;

    public function __construct($id, $module, NotifyTriesRepository $notifyTriesRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->notifyTriesRepository = $notifyTriesRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => AccessControl::class,
                'only' => ['set-confirmation'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['contact.force-verify'],
                    ]
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
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '@contact/index',
                ],
            ],
            'index' => [
                'class' => IndexAction::class,
            ],
            'search' => [
                'class' => SearchAction::class,
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => ['with_counters' => 1],
                'on beforePerform' => function ($event) {
                    /** @var ViewAction $action */
                    $action = $event->sender;

                    $action->getDataProvider()->query
                        ->andFilterWhere(['with_documents' => true])->joinWith('documents');
                }
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'scenario' => 'create',
                'data' => function ($action) {
                    return [
                        'countries' => $action->controller->getRefs('country_code'),
                        'scenario' => 'create',
                    ];
                },
                'success' => Yii::t('hipanel:client', 'Contact was created'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', 'Contact was deleted'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'update',
                'success' => Yii::t('hipanel:client', 'Contact was updated'),
                'data' => function ($action) {
                    return [
                        'countries' => $action->controller->getRefs('country_code'),
                        'askPincode' => Client::perform('HasPincode'),
                        'scenario' => 'update',
                    ];
                },
            ],
            'copy' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'create',
                'data' => function ($action) {
                    return [
                        'countries' => $action->controller->getRefs('country_code'),
                        'scenario' => 'create',
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
                'success' => Yii::t('hipanel:client', 'Confirmation message was sent to your email')
            ],
        ];
    }

    public function actionAttachDocuments($id)
    {
        $contact = Contact::find()->joinWith('documents')->where(['id' => $id])->one();

        if ($contact === null) {
            throw new NotFoundHttpException();
        }

        $model = new DocumentUploadForm(['id' => $contact->id]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $session = Yii::$app->session;
            if ($model->save()) {
                $session->addFlash('success', Yii::t('hipanel:client', 'Documents were saved'));

                return $this->redirect(['attach-documents', 'id' => $id]);
            }

            $session->addFlash('error', $model->getFirstError('title'));
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
            'tries' => $tries
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
                return ['success' => true];
            } catch (PhoneConfirmationException $e) {
                return ['error' => $e->getMessage()];
            }
        }

        return ['error' => true];
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
}
