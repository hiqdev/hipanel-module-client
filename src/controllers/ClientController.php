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
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\RedirectAction;
use hipanel\actions\RenderJsonAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\ViewAction;
use hipanel\helpers\Url;
use hipanel\models\Ref;
use hipanel\modules\client\models\Client;
use hiqdev\hiart\Collection;
use Yii;
use yii\base\Event;

class ClientController extends \hipanel\base\CrudController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::class,
                'on beforePerform' => function ($event) {
                    if (!Yii::$app->user->can('support')) {
                        Yii::$app->response->redirect(Url::to(['@client/view', 'id' => Yii::$app->user->id]))->send();
                    }
                },
                'data' => function ($action) {
                    return [
                        'states' => $action->controller->getStates(),
                    ];
                },
                'filterStorageMap' => [
                    'login_like' => 'client.client.login_like',
                    'state' => 'client.client.state',
                    'type' => 'client.client.type',
                    'seller' => 'client.client.seller',
                ],
            ],
            'search' => [
                'class' => SearchAction::class,
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('app', 'Client is created'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Client is updated'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('app', 'Client is deleted'),
            ],
            'enable-block' => [
                'class' => SmartPerformAction::class,
                'success' => 'Client was blocked successfully',
                'error' => 'Error during the client account blocking',
            ],
            'disable-block' => [
                'class' => SmartPerformAction::class,
                'success' => 'Client was unblocked successfully',
                'error' => 'Error during the client account unblocking',
            ],
            'change-password' => [
                'class' => SmartUpdateAction::class,
                'view' => '_changePasswordModal',
                'POST' => [
                    'save' => true,
                    'success' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            return ['success' => !$action->collection->hasErrors()];
                        },
                    ],
                ],
            ],
            'set-tmp-password' => [
                'class'   => SmartUpdateAction::class,
                'view'    => '_setTmpPasswordModal',
                'POST' => [
                    'save' => true,
                    'success' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            return ['success' => !$action->collection->hasErrors()];
                        },
                    ],
                ],
            ],
            'view' => [
                'class' => ViewAction::class,
                'findOptions' => [
                    'select' => '*,contact,purses,last_seen,tickets_count,servers_count,hosting_count,contacts_count',
                    'with_domains_count' => Yii::getAlias('@domain', false) ? 1 : 0,
                ],
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'set-credit' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('app', 'Credit changed'),
            ],
            'bulk-enable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'enable-block',
                'success' => Yii::t('hipanel/client', 'Clients were blocked successfully'),
                'error' => Yii::t('hipanel/client', 'Error during the clients blocking'),
                'POST html' => [
                    'save'    => true,
                    'success' => [
                        'class' => RedirectAction::class,
                    ],
                ],
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\Action $action */
                    $action = $event->sender;
                    $type = Yii::$app->request->post('type');
                    $comment = Yii::$app->request->post('comment');
                    if (!empty($type)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttributes([
                                'type' => $type,
                                'comment' => $comment,
                            ]);
                        }
                    }
                },
            ],
            'bulk-enable-block-modal' => [
                'class' => PrepareBulkAction::class,
                'scenario' => 'enable-block',
                'view' => '_bulkEnableBlock',
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'blockReasons' => $this->getBlockReasons(),
                    ]);
                },
            ],
            'bulk-disable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'disable-block',
                'success' => Yii::t('hipanel/client', 'Clients were unblocked successfully'),
                'error' => Yii::t('hipanel/client', 'Error during the clients unblocking'),
                'POST html' => [
                    'save'    => true,
                    'success' => [
                        'class' => RedirectAction::class,
                    ],
                ],
                'on beforeSave' => function (Event $event) {
                    /** @var \hipanel\actions\Action $action */
                    $action = $event->sender;
                    $comment = Yii::$app->request->post('comment');
                    if (!empty($type)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttribute('comment', $comment);
                        }
                    }
                },
            ],
            'bulk-disable-block-modal' => [
                'class' => PrepareBulkAction::class,
                'scenario' => 'disable-block',
                'view' => '_bulkDisableBlock',
            ],
        ];
    }

    public function getStates()
    {
        return Ref::getList('state,client');
    }

    public function actionPincodeSettings($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'pincode-settings';
        $request = Yii::$app->request;

        if ($request->isAjax && Yii::$app->request->isPost) {
            $model = (new Collection(['model' => $model]))->load()->first;
            $model::perform($model->pincode_enabled ? 'DisablePincode' : 'EnablePincode', $model->dirtyAttributes);
            Yii::$app->end();
        }
        $model->setAttributes(Client::perform('HasPincode', ['id' => $id]));
        $apiData = Ref::getList('type,question');
        $questionList = array_merge(Client::makeTranslateQuestionList($apiData),
            ['own' => Yii::t('app', 'Own question')]);

        return $this->renderAjax('_pincodeSettingsModal', ['model' => $model, 'questionList' => $questionList]);
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
                'values' => $model->dirtyAttributes,
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

        if ($request->isAjax && Yii::$app->request->isPost) {
            $model = (new Collection(['model' => $model]))->load()->first;
            $model->perform('SetClassValues', [
                'id' => $id,
                'class' => 'client,access',
                'values' => $model->dirtyAttributes,
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

        if ($request->isAjax && Yii::$app->request->isPost) {
            $model = (new Collection(['model' => $model]))->load()->first;
            $model->perform('SetClassValues', [
                'id' => $id,
                'class' => 'client,domain_defaults',
                'values' => $model->dirtyAttributes,
            ]);
            Yii::$app->end();
        }
        $model->setAttributes($model->perform('GetClassValues', ['id' => $id, 'class' => 'client,domain_defaults']));

        return $this->renderAjax('_domainSettingsModal', ['model' => $model]);
    }
}
