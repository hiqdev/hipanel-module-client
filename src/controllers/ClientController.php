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

use hipanel\actions\Action;
use hipanel\actions\ClassValuesAction;
use hipanel\actions\ComboSearchAction;
use hipanel\actions\IndexAction;
use hipanel\actions\PrepareBulkAction;
use hipanel\actions\RenderJsonAction;
use hipanel\actions\SearchAction;
use hipanel\actions\SmartCreateAction;
use hipanel\actions\SmartDeleteAction;
use hipanel\actions\SmartPerformAction;
use hipanel\actions\SmartUpdateAction;
use hipanel\actions\ValidateFormAction;
use hipanel\actions\VariantsAction;
use hipanel\actions\ViewAction;
use hipanel\base\CrudController;
use hipanel\filters\EasyAccessControl;
use hipanel\helpers\Url;
use hipanel\modules\client\actions\ChangePaymentStatusAction;
use hipanel\modules\client\actions\DeleteClientsByLoginsAction;
use hipanel\modules\client\forms\ChangePaymentStatusForm;
use hipanel\modules\client\logic\IPConfirmer;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\ClientSearch;
use hipanel\modules\client\models\query\ClientQuery;
use hipanel\modules\ticket\models\Template;
use hiqdev\hiart\Collection;
use yii\helpers\ArrayHelper;
use RuntimeException;
use Yii;
use yii\base\Event;
use yii\filters\VerbFilter;
use hipanel\actions\RenderAction;
use hipanel\models\Ref;

class ClientController extends CrudController
{
    public function behaviors()
    {
        $createUserPermissions = $this->module->userCreationIsDisabled ? false : ['employee.create', 'client.create'];

        return array_merge(parent::behaviors(), [
            [
                'class' => EasyAccessControl::class,
                'actions' => [
                    'update,merchant-payment' => 'client.update',
                    'delete' => 'client.delete',
                    'delete-by-logins' => 'client.delete',
                    'create' => $createUserPermissions,
                    'enable-block' => 'client.block',
                    'disable-block' => 'client.unblock',
                    'set-verified' => 'contact.force-verify',
                    'perform-billing, set-credit' => 'bill.create',
                    'set-description' => 'client.set-description',
                    'set-note' => 'client.set-note',
                    'set-tmp-password' => 'client.set-tmp-pwd',
                    'index, search' => ['client.read', 'employee.read'],
                    'allow-i-p' => true,
                    'restore-password' => true,
                    'my-test' => true,
                    '*' => '@',
                ],
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'set-verified' => ['post'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        return array_merge(parent::actions(), [
            'index' => [
                'class' => IndexAction::class,
                'responseVariants' => [
                    'get-total-count' => fn(VariantsAction $action): int => Client::find()->count(),
                ],
                'on beforePerform' => function (Event $event) {
                    $user = Yii::$app->user;
                    if (!$user->isGuest && !$user->can('client.list')) {
                        Yii::$app->response->redirect(Url::to(['@client/view', 'id' => $user->id]))->send();
                    }

                    $action = $event->sender;
                    /** @var ClientQuery $query */
                    $query = $action->getDataProvider()->query;
                    $representation = $action->controller->indexPageUiOptionsModel->representation;
                    $query->addSelect(['contact'])->withContact();

                    if (in_array($representation, ['servers', 'documents'], true)) {
                        $query->addSelect(['purses'])->withPurses();
                    }

                    switch ($representation) {
                        case 'servers':
                            $query->addSelect(['accounts_count', Yii::getAlias('@server', false) ? 'servers_count' : null, 'targets_count']);
                            break;
                        case 'documents':
                            $query->addSelect(['documents']);
                            break;
                        case 'profit-report':
                            $query->withProfit();
                            break;
                        case 'referral':
                            $query->withReferral();
                            break;
                    }
                },
                'data' => function ($action) {
                    return [
                        'types' => $this->getRefs('type,client', 'hipanel:client'),
                        'states' => $this->getRefs('state,client', 'hipanel:client'),
                        'debt_labels' => ClientSearch::getDebtLabels(),
                    ];
                },
                'filterStorageMap' => [
                    'login_ilike' => 'client.client.login_ilike',
                    'state' => 'client.client.state',
                    'states' => 'client.client.states',
                    'type' => 'client.client.type',
                    'seller' => 'client.client.seller',
                    'seller_id' => 'client.client.seller_id',
                    'name_ilike' => 'client.client.name_ilike',
                ],
            ],
            'search' => [
                'class' => ComboSearchAction::class,
            ],
            'create' => [
                'class' => SmartCreateAction::class,
                'success' => Yii::t('hipanel:client', 'Client was created'),
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'currencies' => Ref::getList('type,currency'),
                    ]);
                },
            ],
            'update' => [
                'class' => SmartUpdateAction::class,
                'success' => Yii::t('hipanel:client', 'Client was updated'),
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'currencies' => Ref::getList('type,currency'),
                    ]);
                },
            ],
            'delete-by-logins' => [
                'class' => DeleteClientsByLoginsAction::class,
            ],
            'delete' => [
                'class' => SmartDeleteAction::class,
                'success' => Yii::t('hipanel:client', 'Client(s) were deleted'),
                'error' => Yii::t('hipanel:client', 'Failed to delete client(s)'),
            ],
            'bulk-delete-modal' => [
                'class' => PrepareBulkAction::class,
                'view' => '_bulkDelete',
            ],
            'enable-block' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Client(s) were blocked successfully'),
                'error' => Yii::t('hipanel:client', 'Failed to block client(s)'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    $type = Yii::$app->request->post('type');
                    $comment = Yii::$app->request->post('comment');
                    if (!empty($type) || !empty($comment)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttributes(array_filter([
                                'type' => $type,
                                'comment' => $comment,
                            ]));
                        }
                    }
                },
            ],
            'disable-block' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Client(s) were unblocked successfully'),
                'error' => Yii::t('hipanel:client', 'Failed to unblock client(s)'),
                'on beforeSave' => function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    $type = Yii::$app->request->post('type');
                    $comment = Yii::$app->request->post('comment');
                    if (!empty($type) || !empty($comment)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttributes(array_filter([
                                'type' => $type,
                                'comment' => $comment,
                            ]));
                        }
                    }
                },
            ],
            'change-password' => [
                'class' => SmartUpdateAction::class,
                'view' => '_changePasswordModal',
                'success' => Yii::t('hipanel:client', 'Password changed'),
                'error' => Yii::t('hipanel:client', 'Error during password change'),
            ],
            'set-tmp-password' => [
                'class' => SmartUpdateAction::class,
                'view' => '_setTmpPasswordModal',
                'success' => Yii::t('hipanel:client', 'Temporary password was sent on your email'),
                'error' => Yii::t('hipanel:client', 'Error during temporary password setting'),
            ],
            'perform-billing' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Bills were charged successfully!'),
                'error' => Yii::t('hipanel:client', 'Error during bills charging'),
            ],
            'view' => [
                'class' => ViewAction::class,
                'on beforePerform' => function ($event) {
                    $action = $event->sender;
                    $action->getDataProvider()->query
                        ->addSelect(array_filter([
                            'last_seen',
                            'contacts_count',
                            'blocking',
                            Yii::$app->user->can('document.read') ? 'documents' : null,
                            'purses',
                            Yii::$app->user->can('client.read-deleted') ? 'show_deleted' : null,
                            Yii::getAlias('@domain', false) ? 'domains_count' : null,
                            Yii::getAlias('@ticket', false) ? 'tickets_count' : null,
                            Yii::getAlias('@server', false) ? 'servers_count' : null,
                            Yii::getAlias('@server', false) ? 'servers_count' : null,
                            Yii::getAlias('@hosting', false) ? 'hosting_count' : null,
                            Yii::getAlias('@server', false) && Yii::$app->user->can('resell') ? 'pre_ordered_servers_count' : null,
                            Yii::getAlias('@target', false) ? 'targets_count' : null,
                        ]))
                        ->joinWith(['blocking'])
                        ->withContact()
                        ->withReferral()
                        ->withPurses()
                        ->andFilterWhere(['with_roles' => true]);
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
                'success' => Yii::t('hipanel', 'Note was changed'),
                'error' => Yii::t('hipanel', 'Failed to change note'),
            ],
            'bulk-enable-block-modal' => [
                'class' => PrepareBulkAction::class,
                'view' => '_bulkEnableBlock',
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'blockReasons' => $this->getBlockReasons(),
                    ]);
                },
            ],
            'bulk-disable-block-modal' => [
                'class' => PrepareBulkAction::class,
                'view' => '_bulkDisableBlock',
                'data' => function ($action, $data) {
                    return array_merge($data, [
                        'blockReasons' => $this->getBlockReasons(),
                    ]);
                },
            ],
            'ip-restrictions' => [
                'class' => ClassValuesAction::class,
                'setApiCommand' => 'set-allowed-ips',
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
            'finance-settings' => [
                'class' => ClassValuesAction::class,
                'valuesClass' => 'client,finance_settings',
                'view' => '_financeSettingsModal',
            ],
            'set-attributes' => [
                'class' => SmartUpdateAction::class,
                'view' => '_set-attributes-form',
                'success' => Yii::t('hipanel:client', 'Set additional information'),
            ],
            'merchant-payment' => [
                'findOptions' => ['with_roles' => true],
                'class' => ChangePaymentStatusAction::class,
                'view' => 'modals/merchant-payment',
                'success' => Yii::t('hipanel:client', 'Merchant payment status has been changed'),
                'scenario' => 'change-payment-status',
                'collection' => [
                    'class' => Collection::class,
                    'model' => new ChangePaymentStatusForm(['scenario' => 'change-payment-status']),
                    'scenario' => 'change-payment-status',
                ],
                'data' => function (Action $action, array $data) {
                    $result = [];
                    foreach ($data['models'] as $model) {
                        $result['models'][] = new ChangePaymentStatusForm($model);
                    }
                    $result['model'] = reset($result['models']);

                    return $result;
                },
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
                    Yii::$app->cache->delete(['user-pincode-enabled', Yii::$app->user->id]);
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
            'set-description' => [
                'class' => SmartUpdateAction::class,
                'view' => '_setDescriptionModal',
                'success' => Yii::t('hipanel', 'Description was changed'),
                'error' => Yii::t('hipanel', 'Failed to change description'),
            ],
            'create-notifications' => [
                'class' => SmartPerformAction::class,
                'success' => Yii::t('hipanel:client', 'Notification was created'),
                'on beforeSave' => function(Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    $template_id = Yii::$app->request->post('template_id');
                    $topic = Yii::$app->request->post('topic');
                    if (!empty($template_id)) {
                        foreach ($action->collection->models as $model) {
                            $model->setAttributes(array_filter([
                                'template_id' => $template_id,
                                'topic' => $topic,
                            ]));
                        }
                    }
                },
            ],
            'bulk-create-notification-modal' => [
                'class' => PrepareBulkAction::class,
                'view' => 'modals/bulk-notifications',
                'on beforePerform' => static function (Event $event) {
                    /** @var Action $action */
                    $action = $event->sender;
                    $action->getDataProvider()->query->addSelect(['simple-list']);
                },
                'data' => function($action, $data) {
                    $templates = ArrayHelper::map(Template::find()->all(), 'id', 'name');
                    return array_merge($data, [
                        'templates' => $templates,
                    ]);
                },
            ],
            'my-test' => [
                'class' => RenderAction::class,
                'on beforeRun' => function (Event $event) {
                    Yii::$app->get('hiart')->disableAuth();
                },
            ],
        ]);
    }

    public function actionAllowIP($id = null)
    {
        $confirmer = Yii::createObject(IPConfirmer::class);
        if ($confirmer->confirm()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('hipanel:client', 'IP was allowed successfully'));
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('hipanel:client', 'Error happened during adding IP'));
        }

        $to = $id ? ['@contact/view', 'id' => $id] : ['/site/profile'];

        return $this->redirect($to);
    }

    public function actionRestorePassword($id = null)
    {
        Yii::$app->get('hiart')->disableAuth();
        $url = Yii::getAlias('@HIAM_SITE', false) . Url::to(array_merge(['/site/reset-password'], Yii::$app->request->get()));

        return $this->redirect($url);
    }

    public function actionSetReferralTariff($id)
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $client = new Client(['id' => $id, 'scenario' => 'set-referral-tariff']);
        if ($request->isAjax) {
            return $this->renderAjax('modals/set-referral-tariff', ['client' => $client]);
        }
        if ($client->load($request->post()) && $client->validate()) {
            try {
                Client::batchPerform('set-tariffs', [$id => $client->attributes]);
                $session->addFlash('success', Yii::t('hipanel:client', 'Referral tariff have been successfully changed'));
            } catch (RuntimeException $e) {
                $session->addFlash('error', $e->getMessage());
            }
        }

        return $this->redirect(['@client/view', 'id' => $id]);
    }
}
