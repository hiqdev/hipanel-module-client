<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\CurrencyColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\finance\controllers\BillController;
use hipanel\helpers\Url;
use hipanel\modules\client\widgets\State as ClientState;
use hipanel\modules\client\widgets\Type as ClientType;
use Yii;
use yii\helpers\Html;
use hipanel\modules\client\models\Client;

class ClientGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'id' => [
                'class'         => ClientColumn::className(),
                'attribute'     => 'id',
                'nameAttribute' => 'login',
                'label'         => Yii::t('app', 'Client'),
            ],
            'login' => [
                'attribute'       => 'login',
                'filterAttribute' => 'login_like',
                'format'          => 'html',
                'value'           => function ($model) {
                    return Html::a($model->login, ['@client/view', 'id' => $model->id]);
                },
            ],
            'name' => [
                'filterAttribute' => 'name_like',
            ],
            'state' => [
                'class'  => RefColumn::className(),
                'format' => 'raw',
                'gtype'  => 'state,client',
                'value'  => function ($model) {
                    return ClientState::widget(compact('model'));
                },
            ],
            'type' => [
                'class'  => RefColumn::className(),
                'format' => 'raw',
                'gtype'  => 'type,client',
                'value'  => function ($model) {
                    return ClientType::widget(compact('model'));
                },
            ],
            'balance' => [
                'class'          => CurrencyColumn::className(),
                'compare'        => 'credit',
                'filter'         => false,
                'attribute'      => 'balance',
                'urlCallback'    => function ($model) { return BillController::getSearchUrl(['client' => $model->login]); },
                'headerOptions'  => ['class' => 'text-right'],
                'contentOptions' => ['class' => 'text-right text-bold'],
            ],
            'credit' => Yii::$app->user->can('manage') ? [
                'class'         => 'hiqdev\xeditable\grid\XEditableColumn',
                'attribute'     => 'credit',
                'filter'        => false,
                'format'        => ['currency', 'USD'],
                'pluginOptions' => [
                    'url'   => 'set-credit',
                    'title' => Yii::t('app', 'Set credit'),
                ],
            ] : [
                'class' => CurrencyColumn::className(),
            ],
            'country' => [
                'attribute' => 'contact',
                'label'     => Yii::t('app', 'Country'),
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
                'label'     => Yii::t('app', 'Tickets'),
                'value'  => function ($model) {
                    $num = $model->count['tickets'];
                    $url = Url::toSearch('ticket', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'tickets'), $url) : '';
                },
            ],
            'servers' => [
                'format' => 'html',
                'label'     => Yii::t('app', 'Servers'),
                'value'  => function ($model) {
                    $num = $model->count['servers'];
                    $url = Url::toSearch('server', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'servers'), $url) : '';
                },
            ],
            'domains' => [
                'format' => 'html',
                'label'     => Yii::t('app', 'Domains'),
                'value'  => function ($model) {
                    $num = $model->count['domains'];
                    $url = Url::toSearch('domain', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'domains'), $url) : '';
                },
            ],
            'contacts' => [
                'format' => 'html',
                'label'     => Yii::t('app', 'Contacts'),
                'value'  => function ($model) {
                    $num = $model->count['contacts'];
                    $url = Url::toSearch('contact', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'contacts'), $url) : '';
                },
            ],
            'hosting' => [
                'format' => 'html',
                'label'     => Yii::t('app', 'Hosting'),
                'value'  => function ($model) {
                    $num = $model->count['accounts'];
                    $url = Url::toSearch('account', ['client_id' => $model->id]);
                    $res .= $num ? Html::a($num . ' ' . Yii::t('app', 'accounts'), $url) : '';
                    $num = $model->count['hdomains'];
                    $url = Url::toSearch('hdomain', ['client_id' => $model->id]);
                    $res .= $num ? Html::a($num . ' ' . Yii::t('app', 'domains'), $url) : '';
                    $num = $model->count['dbs'];
                    $url = Url::toSearch('db', ['client_id' => $model->id]);
                    $res .= $num ? Html::a($num . ' ' . Yii::t('app', 'databases'), $url) : '';

                    return $res;
                },
            ],
            'action' => [
                'class'    => ActionColumn::className(),
                'template' => Yii::$app->user->can('support') ? '{view} {enable-block} {disable-block} {delete}' : '{view}',
                'header'   => Yii::t('app', 'Actions'),
                'buttons'  => [
                    'enable-block'  => function ($url, $model, $key) {
                        return (!Client::canBeSelf($model) && ($model->state!='blocked'))
                            ? Html::a('<i class="fa fa-ban"></i>' . Yii::t('app','Enable block'), ['enable-block', 'id' => $model->id]) : '';
                    },
                    'disable-block' => function ($url, $model, $key) {
                        return (!Client::canBeSelf($model) && ($model->state=='blocked'))
                            ? Html::a('<i class="fa fa-ban"></i>' . Yii::t('app','Disable block'), ['disable-block','id' => $model->id]) : '';
                    },
                    'delete'        => function ($url, $model, $key) {
                        return !Client::canBeSelf($model)
                            ? Html::a('<i class="fa fa-trash-o"></i>' . Yii::t('app','Delete'), $url, [
                                    'title'     => Yii::t('app','Delete'),
                                    'aria-label'=> Yii::t('app','Delete'),
                                    'data'      => [
                                        'confirm'   => Yii::t('app', 'Are you sure you want to delete client {client}?', ['client' => $model->login]),
                                        'method'    => 'post',
                                        'data-pjax' => '0',
                                    ],
                              ]) : '';
                    },
                ],
            ],
        ];
    }
}
