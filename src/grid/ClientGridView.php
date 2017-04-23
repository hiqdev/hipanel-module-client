<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\grid\RefColumn;
use hipanel\grid\XEditableColumn;
use hipanel\helpers\Url;
use hipanel\modules\client\menus\ClientActionsMenu;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\ClientState;
use hipanel\modules\client\widgets\ClientType;
use hipanel\modules\finance\grid\BalanceColumn;
use hipanel\modules\finance\grid\CreditColumn;
use hipanel\widgets\ArraySpoiler;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

class ClientGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'id' => [
                'class'         => ClientColumn::class,
                'attribute'     => 'id',
                'nameAttribute' => 'login',
                'label'         => Yii::t('hipanel', 'Client'),
            ],
            'login' => [
                'class'           => MainColumn::class,
                'attribute'       => 'login',
                'filterAttribute' => 'login_ilike',
                'format'          => 'raw',
                'note'            => Yii::$app->user->can('manage') ? 'note' : null,
                'noteOptions'     => [
                    'url' => Url::to('set-note'),
                ],
            ],
            'note' => [
                'class' => XEditableColumn::class,
                'pluginOptions' => [
                    'url'       => Url::to('set-note'),
                ],
                'widgetOptions' => [
                    'linkOptions' => [
                        'data-type' => 'textarea',
                    ],
                ],
                'visible' => Yii::$app->user->can('manage'),
            ],
            'name' => [
                'filterAttribute' => 'name_ilike',
            ],
            'state' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'states',
                'format' => 'raw',
                'gtype'  => 'state,client',
                'i18nDictionary' => 'hipanel:client',
                'value'  => function ($model) {
                    return ClientState::widget(compact('model'));
                },
            ],
            'type' => [
                'class'  => RefColumn::class,
                'filterAttribute' => 'types',
                'format' => 'raw',
                'gtype'  => 'type,client',
                'i18nDictionary' => 'hipanel:client',
                'value'  => function ($model) {
                    return ClientType::widget(compact('model'));
                },
            ],
            'balance' => [
                'class' => BalanceColumn::class,
            ],
            'balance_with_purses' => [
                'format' => 'raw',
                'attribute' => 'balance',
                'value' => function ($model) {
                }
            ],
            'credit' => CreditColumn::resolveConfig(),
            'country' => [
                'attribute' => 'contact',
                'label'     => Yii::t('hipanel:client', 'Country'),
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::tag('span', '', ['class' => 'flag-icon flag-icon-' . $model->contact['country']]) .
                        '&nbsp;&nbsp;' . $model->contact['country_name'];
                },
            ],
            'create_date' => [
                'attribute'      => 'create_time',
                'format'         => 'date',
                'filter'         => false,
                'contentOptions' => ['class' => 'text-nowrap'],
            ],
            'create_time' => [
                'attribute' => 'create_time',
                'format'    => 'datetime',
                'filter'    => false,
            ],
            'update_date' => [
                'attribute'      => 'update_time',
                'format'         => 'date',
                'filter'         => false,
                'contentOptions' => ['class' => 'text-nowrap'],
            ],
            'update_time' => [
                'attribute' => 'update_time',
                'format'    => 'datetime',
                'filter'    => false,
            ],
            'last_seen' => [
                'attribute'      => 'last_seen',
                'format'         => 'date',
                'filter'         => false,
                'contentOptions' => ['class' => 'text-nowrap'],
                'value'          => '',
            ],
            'tickets' => [
                'format' => 'html',
                'label'     => Yii::t('hipanel', 'Tickets'),
                'value'  => function ($model) {
                    $num = $model->count['tickets'];
                    $url = Url::toSearch('ticket', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# ticket} other{# tickets}}', $num), $url) : '';
                },
            ],
            'servers' => [
                'format' => 'raw',
                'visible' => Yii::getAlias('@server', false) !== false,
                'label' => Yii::t('hipanel', 'Servers'),
                'value' => function ($model) {
                    /** @var Client $model */
                    $result = [];

                    if ($num = $model->count['servers']) {
                        $result[] = Html::a(
                            Yii::t('hipanel', '{0, plural, one{# server} other{# servers}}', $num),
                            Url::toSearch('server', ['client_id' => $model->id])
                        );
                    }

                    if (Yii::$app->user->can('resell') && $num = $model->count['pre_ordered_servers']) {
                        $result[] = Html::a(
                            Yii::t('hipanel:client', '{0, plural, one{# pre-ordered server} other{# pre-ordered servers}}', $num),
                            Url::to(['@pre-order', 'ChangeSearch' => ['client_id' => $model->id]])
                        );
                    }

                    return implode(', ', $result);
                },
            ],
            'domains' => [
                'format' => 'html',
                'visible' => Yii::getAlias('@domain', false) !== false,
                'label' => Yii::t('hipanel', 'Domains'),
                'value' => function ($model) {
                    /** @var Client $model */
                    $num = $model->count['domains'];
                    $url = Url::toSearch('domain', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# domain} other{# domains}}', $num), $url) : '';
                },
            ],
            'domains_spoiler' => [
                'format' => 'raw',
                'visible' => Yii::getAlias('@domain', false) !== false,
                'label' => Yii::t('hipanel', 'Domains'),
                'value' => function ($model) {
                    /** @var Client $model */
                    return ArraySpoiler::widget([
                        'id' => uniqid('ds'),
                        'data' => $model->domains,
                        'visibleCount' => 1,
                        'button' => [
                            'label' => '+' . ($model->count['domains'] - 1),
                            'popoverOptions' => [
                                'html' => true,
                            ],
                        ],
                        'formatter' => function ($item, $key) use ($model) {
                            static $index = 0;
                            ++$index;

                            $value = Html::a($item->domain, ['@domain/view', 'id' => $item->id]);
                            if ($model->count['domains'] > count($model->domains) && $index === count($model->domains)) {
                                $text = Yii::t('hipanel:client', 'and {n} more', ['n' => $model->count['domains'] - count($model->domains)]);
                                $value .= ' ' . Html::a($text, Url::toSearch('domain', ['client_id' => $model->id]), ['class' => 'border-bottom-dashed']);
                            }

                            return $value;
                        },
                    ]);
                },
            ],
            'servers_spoiler' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel', 'Servers'),
                'value' => function ($model) {
                    return ArraySpoiler::widget([
                        'id' => uniqid('ss'),
                        'data' => $model->servers,
                        'visibleCount' => 1,
                        'button' => [
                            'label' => '+' . ($model->count['servers'] - 1),
                            'popoverOptions' => [
                                'html' => true,
                            ],
                        ],
                        'formatter' => function ($item, $key) use ($model) {
                            static $index;
                            ++$index;

                            $value = Html::a($item->name, ['@server/view', 'id' => $item->id]);
                            if ($model->count['servers'] > count($model->servers) && $index === count($model->servers)) {
                                $text = Yii::t('hipanel:client', 'and {n} more', ['n' => $model->count['servers'] - count($model->servers)]);
                                $value .= ' ' . Html::a($text, Url::toSearch('server', ['client_id' => $model->id]), ['class' => 'border-bottom-dashed']);
                            }

                            return $value;
                        },
                    ]);
                },
            ],
            'contacts' => [
                'format' => 'html',
                'label'     => Yii::t('hipanel', 'Contacts'),
                'value'  => function ($model) {
                    $num = $model->count['contacts'];
                    $url = Url::toSearch('contact', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# contact} other{# contacts}}', $num), $url) : '';
                },
            ],
            'hosting' => [
                'format' => 'html',
                'label'     => Yii::t('hipanel', 'Hosting'),
                'value'  => function ($model) {
                    $res = '';
                    $num = $model->count['accounts'];
                    $url = Url::toSearch('account', ['client_id' => $model->id]);
                    $res .= $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# account} other{# accounts}}', $num), $url) : '';
                    $num = $model->count['hdomains'];
                    $url = Url::toSearch('hdomain', ['client_id' => $model->id]);
                    $res .= $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# domain} other{# domains}}', $num), $url) : '';
                    $num = $model->count['dbs'];
                    $url = Url::toSearch('db', ['client_id' => $model->id]);
                    $res .= $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# database} other{# databases}}', $num), $url) : '';

                    return $res;
                },
            ],
            'messengers' => [
                'format' => 'html',
                'label' => Yii::t('hipanel:client', 'Messengers'),
                'value' => function ($model) {
                    return $model->contact->messengers;
                }
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => ClientActionsMenu::class,
            ],
            'payment_ticket' => [
                'format' => 'html',
                'label' => Yii::t('hipanel', 'Ticket'),
                'filter' => false,
                'value' => function ($model) {
                    if (!$model->payment_ticket_id)
                    {
                        return '';
                    }
                    return Html::a(
                        $model->payment_ticket_id,
                        Url::to(['@ticket/view', 'id' => $model->payment_ticket_id]),
                        [
                            'class' => $model->balance >= 0 && $model->payment_ticket->state === 'opened' ? 'text-red' :
                                ($model->balance >= 0 ? 'text-purple'
                                    : ( $model->payment_ticket->state === 'closed' ? 'text-red bold'
                                        : ($model->payment_ticket->status === 'wait_admin' ? 'text-green' : 'text-blue')))
                    ]);
                }
            ],
        ];
    }

    public static function defaultRepresentations()
    {
        return [
            'common' => [
                'label'   => Yii::t('hipanel', 'Common'),
                'columns' => [
                    'checkbox',
                    'login',
                    'name', 'seller_id',
                    'type', 'state',
                    'balance', 'credit',
                ],
            ],
            'payment' => Yii::$app->user->can('support') ? [
                'label'   => Yii::t('hipanel:client', 'Payment'),
                'columns' => [
                    'checkbox', 'login', 'seller_id','type', 'state',
                    'balance', 'payment_ticket',
                ],
            ] : null,
            'documents' => Yii::$app->user->can('support') ? [
                'label'   => Yii::t('hipanel:client', 'Documents'),
                'columns' => [
                    'checkbox', 'login',
                ],
            ] : null,
        ];
    }
}
