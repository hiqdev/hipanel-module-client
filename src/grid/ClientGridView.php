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
use hipanel\modules\client\controllers\ContactController;
use hipanel\modules\client\widgets\State as ClientState;
use hipanel\modules\client\widgets\Type as ClientType;
use hipanel\modules\domain\controllers\DomainController;
use hipanel\modules\hosting\controllers\AccountController;
use hipanel\modules\hosting\controllers\DbController;
use hipanel\modules\hosting\controllers\HdomainController;
use hipanel\modules\server\controllers\ServerController;
use hipanel\modules\ticket\controllers\TicketController;
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
                'class'         => XEditableColumn::className(),
                'visible'       => true, /// show for managers only
                'attribute'     => 'credit',
                'filter'        => false,
                'format'        => ['currency', 'USD'],
                'pluginOptions' => [
                    'url' => 'set-credit',
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
                    $url = TicketController::getSearchUrl(['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'tickets'), $url) : '';
                },
            ],
            'servers' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['servers'];
                    $url = ServerController::getSearchUrl(['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'servers'), $url) : '';
                },
            ],
            'domains' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['domains'];
                    $url = DomainController::getSearchUrl(['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'domains'), $url) : '';
                },
            ],
            'contacts' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['contacts'];
                    $url = ContactController::getSearchUrl(['client_id' => $model->id]);

                    return $num ? Html::a($num . ' ' . Yii::t('app', 'contacts'), $url) : '';
                },
            ],
            'hosting' => [
                'format' => 'html',
                'value'  => function ($model) {
                    $num = $model->count['accounts'];
                    $url = AccountController::getSearchUrl(['client_id' => $model->id]);
                    $res .= $num ? Html::a($num . ' ' . Yii::t('app', 'accounts'), $url) : '';
                    $num = $model->count['hdomains'];
                    $url = HdomainController::getSearchUrl(['client_id' => $model->id]);
                    $res .= $num ? Html::a($num . ' ' . Yii::t('app', 'domains'), $url) : '';
                    $num = $model->count['dbs'];
                    $url = DbController::getSearchUrl(['client_id' => $model->id]);
                    $res .= $num ? Html::a($num . ' ' . Yii::t('app', 'databases'), $url) : '';

                    return $res;
                },
            ],
            'action' => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {block} {delete} {update}', // {state}
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
