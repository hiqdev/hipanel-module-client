<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\controllers;

use hipanel\models\Ref;
use hipanel\modules\client\models\Client;
use hipanel\modules\domain\models\Domain;
use Yii;
use yii\web\Response;

class ClientController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'hipanel\actions\IndexAction',
                'data' => function ($action) {
                    return [
                        'states' => $action->controller->getStates(),
                    ];
                },
            ],
            'create' => [
                'class' => 'hipanel\actions\SmartCreateAction',
                'success' => Yii::t('app', 'Client is created'),
            ],
            'update' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Client is updated'),
            ],
            'delete' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'Client is deleted'),
            ],
            'enable-block' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'Client is blocked'),
            ],
            'disable-block' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => Yii::t('app', 'Client is unblocked'),
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'findOptions' => [
                    'with_tickets_count' => 1,
                    'with_domains_count' => Yii::getAlias('@domain', false) ? 1 : 0,
                    'with_servers_count' => 1,
                    'with_hosting_count' => 1,
                    'with_contacts_count' => 1,
                    'with_last_seen' => 1,
                    'with_contact' => 1,
                ],
            ],
            'validate-form' => [
                'class' => 'hipanel\actions\ValidateFormAction',
            ],
            'set-credit' => [
                'class' => 'hipanel\actions\SmartUpdateAction',
                'success' => Yii::t('app', 'Credit changed'),
            ],
        ];
    }

    public function getStates()
    {
        return Ref::getList('state,client');
    }

    public function actionTicketSettings()
    {
        $model = new Client;
        $model->scenario = 'ticket-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model::perform('SetClassValues', [
                'class' => 'client,ticket_settings',
                'values' => $model->dirtyAttributes,
            ]);
            Yii::$app->end();
        }
        $model->setAttributes(Client::perform('GetClassValues', ['class' => 'client,ticket_settings']));

        return $this->renderAjax('_ticketSettingsModal', ['model' => $model]);
    }

    public function actionMailingSettings()
    {
        $model = new Client;
        $model->scenario = 'mailing-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetClassValues', [
                'class' => 'client,mailing',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['class' => 'client,mailing']));

        return $this->renderAjax('_mailingSettingsModal', ['model' => $model]);
    }

    public function actionIpRestrictions()
    {
        $model = new Client;
        $model->scenario = 'ip-restrictions';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetClassValues', [
                'class' => 'client,access',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['class' => 'client,access']));

        return $this->renderAjax('_ipRestrictionsModal', ['model' => $model]);
    }

    public function actionDomainSettings()
    {
        $model = new Client;
        $model->scenario = 'domain-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetClassValues', [
                'class' => 'client,domain_defaults',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['class' => 'client,domain_defaults']));

        return $this->renderAjax('_domainSettingsModal', ['model' => $model]);
    }

    public function actionChangePassword($id = null)
    {
        $request = Yii::$app->request;
        $model = $id ? $this->findModel($id) : new Client;
        $model->scenario = 'change-password';
        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('changePassword', [
                'class' => 'client,domain_defaults',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }

        return $this->renderAjax('_changePasswordModal', ['model' => $model]);
    }
}