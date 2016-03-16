<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\ActionColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\RefColumn;
use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\State as ClientState;
use hipanel\modules\client\widgets\Type as ClientType;
use hipanel\modules\finance\grid\CreditColumn;
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
                'label'         => Yii::t('hipanel', 'Client'),
            ],
            'login' => [
                'attribute'       => 'login',
                'filterAttribute' => 'login_like',
                'format'          => 'raw',
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
                'class' => 'hipanel\modules\finance\grid\BalanceColumn',
            ],
            'credit' => CreditColumn::resolveConfig(),
            'country' => [
                'attribute' => 'contact',
                'label'     => Yii::t('hipanel/client', 'Country'),
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
                'format' => 'html',
                'label'     => Yii::t('hipanel', 'Servers'),
                'value'  => function ($model) {
                    $num = $model->count['servers'];
                    $url = Url::toSearch('server', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# server} other{# servers}}', $num), $url) : '';
                },
            ],
            'domains' => [
                'format' => 'html',
                'label'     => Yii::t('hipanel', 'Domains'),
                'value'  => function ($model) {
                    $num = $model->count['domains'];
                    $url = Url::toSearch('domain', ['client_id' => $model->id]);

                    return $num ? Html::a(Yii::t('hipanel', '{0, plural, one{# domain} other{# domains}}', $num), $url) : '';
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
                'label'     => Yii::t('app', 'Hosting'),
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
            'action' => [
                'class'     => ActionColumn::className(),
                'template'  => Yii::$app->user->can('support') ? '{view}' : '{view}',
            ],
        ];
    }
}
