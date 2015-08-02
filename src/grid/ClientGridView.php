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
use hipanel\helpers\Url;
use hipanel\modules\client\widgets\State as ClientState;
use hipanel\modules\client\widgets\Type as ClientType;
use hiqdev\xeditable\grid\XEditableColumn;
use Yii;
use yii\helpers\Html;

class ClientGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'id' => [
                'class'         => ClientColumn::className(),
                'attribute'     => 'id',
                'nameAttribute' => 'login',
                'label'         => 'Client',
            ],
            'login' => [
                'attribute'       => 'login',
                'filterAttribute' => 'login_like',
                'label'           => 'Client',
                'format'          => 'html',
                'value'           => function ($model) {
                    return Html::a($model->login, ['/client/client/view', 'id' => $model->id]);
                },
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
                'class'     => CurrencyColumn::className(),
                'compare'   => 'credit',
                'filter'    => false,
                'attribute' => 'balance',
            ],
            'credit' => [
                'class'         => 'hiqdev\xeditable\grid\XEditableColumn',
                'visible'       => true, /// TODO: show for managers only
                'attribute'     => 'credit',
                'filter'        => false,
                'format'        => ['currency', 'USD'],
                'pluginOptions' => [
                    'url'   => 'set-credit',
                    'title' => Yii::t('app','Set credit'),
                ],
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
                'value'  => function ($model) {
                    $num = $model->count['tickets'];
                    $url = Url::toSearch('ticket', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'tickets'), $url) : '';
                },
            ],
            'servers' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['servers'];
                    $url = Url::toSearch('server', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'servers'), $url) : '';
                },
            ],
            'domains' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['domains'];
                    $url = Url::toSearch('domain', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'domains'), $url) : '';
                },
            ],
            'contacts' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['contacts'];
                    $url = Url::toSearch('contact', ['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'contacts'), $url) : '';
                },
            ],
            'hosting' => [
                'format' => 'html',
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
                'template' => '{view} {block} {delete}', // {state}
                'header'   => Yii::t('app', 'Actions'),
                'buttons'  => [
                    'block' => function ($url, $model, $key) {
                        return Html::a('Close', ['block', 'id' => $model->id]);
                    },
                ],
            ],
        ];
    }
}
