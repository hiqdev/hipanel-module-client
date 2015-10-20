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
use hipanel\modules\client\models\Contact;
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
                'class' => 'hipanel\actions\SmartDeleteAction',
                'success' => Yii::t('app', 'Client is deleted'),
            ],
            'enable-block' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => 'Client was blocked successfully',
                'error' => 'Error during the client account blocking',
            ],
            'disable-block' => [
                'class' => 'hipanel\actions\SmartPerformAction',
                'success' => 'Client was unblocked successfully',
                'error' => 'Error during the client account unblocking',
            ],
            'view' => [
                'class' => 'hipanel\actions\ViewAction',
                'findOptions' => [
                    'select'             => '*,contact,purses,last_seen,tickets_count,servers_count,hosting_count,contacts_count',
                    'with_domains_count' => Yii::getAlias('@domain', false) ? 1 : 0,
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

    public function actionTicketSettings($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'ticket-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model::perform('SetClassValues', [
                'id' => $id,
                'class' => 'client,ticket_settings',
                'values' => $model->dirtyAttributes,
            ]);
            Yii::$app->end();
        }
        $model->setAttributes(Client::perform('GetClassValues', ['id' => $id, 'class' => 'client,ticket_settings']));

        return $this->renderAjax('_ticketSettingsModal', ['model' => $model]);
    }

    public function actionMailingSettings($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'mailing-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetClassValues', [
                'id' => $id,
                'class' => 'client,mailing',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['id' => $id, 'class' => 'client,mailing']));

        return $this->renderAjax('_mailingSettingsModal', ['model' => $model]);
    }

    public function actionIpRestrictions($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'ip-restrictions';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetClassValues', [
                'id' => $id,
                'class' => 'client,access',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['id' => $id, 'class' => 'client,access']));

        return $this->renderAjax('_ipRestrictionsModal', ['model' => $model]);
    }

    public function actionDomainSettings($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'domain-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetClassValues', [
                'id' => $id,
                'class' => 'client,domain_defaults',
                'values' => $model->dirtyAttributes
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['id' => $id, 'class' => 'client,domain_defaults']));

        return $this->renderAjax('_domainSettingsModal', ['model' => $model]);
    }

    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'change-password';
        $request = Yii::$app->request;

        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->perform('SetPaasword', $model->dirtyAttributes);
            Yii::$app->end();
        }

        return $this->renderAjax('_changePasswordModal', ['model' => $model]);
    }
}
