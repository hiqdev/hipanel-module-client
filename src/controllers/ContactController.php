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
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Confirmation;
use hipanel\modules\client\models\Contact;
use hipanel\modules\domain\models\Domain;
use Yii;
use yii\base\Event;

class ContactController extends CrudController
{
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
                'success' => Yii::t('hipanel/client', 'Contact was created'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel/client', 'Contact was deleted'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'update',
                'success' => Yii::t('hipanel/client', 'Contact was updated'),
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
                    'model' => Confirmation::class,
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
        ];
    }

    public function actionChangeContact($contactId = null, $contactType = null, $domainId = null, $domainName = null)
    {
        if (!Yii::$app->request->isPost) {
            $model = $this->findModel($contactId);
            $model->scenario = 'change-contact';

            return $this->render('changeContact', [
                'countries' => $this->getRefs('country_code', 'hipanel'),
                'askPincode' => Client::perform('HasPincode'),
                'model' => $model,
                'domainId' => $domainId,
                'domainName' => $domainName,
                'contactType' => $contactType,
            ]);
        } else {
            $model = new Contact(['scenario' => 'create']);
            if ($model->load(Yii::$app->request->post())) {
                $domainContactInfo = Domain::perform('GetContactsInfo', ['id' => $model->domainId]);
                $setContactOptions = [
                    'domain' => $model->domainName,
                    'id' => $model->domainId,
                ];
                if ($model->save()) {
                    foreach (Domain::$contactOptions as $contact) {
                        $setContactOptions[$contact] = $contact === $model->contactType ?
                            $model->id :
                            $domainContactInfo[$contact]['id'];
                    }
                    Domain::perform('SetContacts', $setContactOptions);
                    $this->redirect(['@domain/view', 'id' => $model->domainId]);
                }
            }
        }
    }
}
