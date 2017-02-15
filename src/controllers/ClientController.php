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

use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\OrientationAction;
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
use hipanel\actions\ClassValuesAction;
use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use Yii;
use yii\base\Event;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ClientController extends \hipanel\base\CrudController
{
    public function behaviors()
    {
        return [
            [
                'class' => AccessControl::class,
                'only' => ['set-verified'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['contact.force-verify'],
                    ],
                ],
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'set-verified' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'set-orientation' => [
                'class' => OrientationAction::class,
                'allowedRoutes' => [
                    '@client/index',
                ],
            ],
            'index' => [
                'class' => IndexAction::class,
                'on beforePerform' => function ($event) {
                    if (!Yii::$app->user->can('support')) {
                        Yii::$app->response->redirect(Url::to(['@client/view', 'id' => Yii::$app->user->id]))->send();
                    }
                },
                'data' => function ($action) {
                    return [
                        'types' => $this->getRefs('type,client', 'hipanel:client'),
                        'states' => $this->getRefs('state,client', 'hipanel:client'),
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
                'class' => ComboSearchAction::class,
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:client', 'Client was created'),
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Client was updated'),
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', 'Client was deleted'),
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
                'class' => SmartUpdateAction::class,
                'view' => '_setTmpPasswordModal',
                'success' => Yii::t('hipanel:client', 'Temporary password was sent on your email'),
                'error' => Yii::t('hipanel:client', 'Error during temporary password setting'),
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforePerform' => function ($event) {
                    $action = $event->sender;
                    $action->getDataProvider()->query
                        ->addSelect(array_filter([
                            'last_seen',
                            'contacts_count',
                            Yii::$app->user->can('manage') ? 'show_deleted' : null,
                            Yii::getAlias('@domain', false) ? 'domains_count' : null,
                            Yii::getAlias('@ticket', false) ? 'tickets_count' : null,
                            Yii::getAlias('@server', false) ? 'servers_count' : null,
                            Yii::getAlias('@server', false) ? 'servers_count' : null,
                            Yii::getAlias('@hosting', false) ? 'hosting_count' : null,
                            Yii::getAlias('@server', false) && Yii::$app->user->can('resell') ? 'pre_ordered_servers_count' : null,
                        ]))
                        ->joinWith([
                            'contact' => function ($query) {
                                $query->joinWith('documents');
                            },
                        ])
                        ->joinWith([
                            'purses' => function ($query) {
                                $query->joinWith('contact')->joinWith('requisite')->joinWith('files');
                            },
                        ]);
                },
            ],
            'validate-form' => [
                'class' => ValidateFormAction::class,
            ],
            'set-credit' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Credit changed'),
            ],
            'set-note' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Note changed'),
                'error' => Yii::t('hipanel:client', 'Failed to change note'),
            ],
            'bulk-enable-block' => [
                'class' => SmartUpdateAction::class,
                'scenario' => 'enable-block',
                'success' => Yii::t('hipanel:client', 'Clients were blocked successfully'),
                'error' => Yii::t('hipanel:client', 'Error during the clients blocking'),
                'POST html' => [
                    'save' => true,
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
                'success' => Yii::t('hipanel:client', 'Clients were unblocked successfully'),
                'error' => Yii::t('hipanel:client', 'Error during the clients unblocking'),
                'POST html' => [
                    'save' => true,
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
            'ip-restrictions' => [
                'class' => ClassValuesAction::class,
                'valuesClass' => 'client,access',
                'view' => '_ipRestrictionsModal',
            ],
            'domain-settings' => [
                'class' => ClassValuesAction::class,
                'valuesClass' => 'client,domain_defaults',
                'view' => '_domainSettingsModal',
                'on beforePerform' => function (Event $event) {
                    $action = $event->sender;
                    foreach (['registrant', 'admin', 'billing', 'tech'] as $key) {
                        if (!$action->model->{$key}) {
                            unset($action->model->{$key});
                        }
                    }
                },
            ],
            'mailing-settings' => [
                'class' => ClassValuesAction::class,
                'valuesClass' => 'client,mailing',
                'view' => '_mailingSettingsModal',
            ],
            'ticket-settings' => [
                'class' => ClassValuesAction::class,
                'valuesClass' => 'client,ticket_settings',
                'view' => '_ticketSettingsModal',
            ],
            'pincode-settings' => [
                'class' => SmartUpdateAction::class,
                'view' => '_pincodeSettingsModal',
                'success' => Yii::t('hipanel:client', 'Pincode settings were updated'),
                'on beforeFetch' => function ($event) {
                    /** @var SearchAction $action */
                    $action = $event->sender;
                    $dataProvider = $action->getDataProvider();
                    $dataProvider->query->addSelect('pincode_enabled');
                },
                'data' => function ($action, $data) {
                    $apiData = $this->getRefs('type,question', 'hipanel:client');
                    $questionList = array_merge(Client::makeTranslateQuestionList($apiData), ['own' => Yii::t('hipanel:client', 'Own question')]);

                    return array_merge(['questionList' => $questionList], $data);
                },
            ],
            'set-verified' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Client verification status has been changed'),
                'POST ajax' => [
                    'save' => true,
                    'flash' => true,
                    'success' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            $message = Yii::$app->session->removeFlash('success');
                            return [
                                'success' => true,
                                'text' => Yii::t('hipanel:client', reset($message)['text']),
                            ];
                        },
                    ],
                    'error' => [
                        'class' => RenderJsonAction::class,
                        'return' => function ($action) {
                            $message = Yii::$app->session->removeFlash('error');
                            return [
                                'success' => false,
                                'text' => reset($message)['text'],
                            ];
                        },
                    ],
                ],

            ],
        ];
    }
}
