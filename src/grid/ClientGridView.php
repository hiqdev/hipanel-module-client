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
use hiqdev\xeditable\grid\XEditableColumn;
use hipanel\grid\RefColumn;
use hipanel\modules\client\widgets\State as ClientState;
use hipanel\modules\client\widgets\Type as ClientType;
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
                'class'     => XEditableColumn::className(),
                'visible'   => true, /// show for managers only
                'attribute' => 'credit',
                'filter'    => false,
                'format'    => ['currency', 'USD'],
                'pluginOptions' => [
                    'url' => 'set-credit',
                ],
            ],
            'create_time' => [
                'attribute'      => 'create_time',
                'format'         => 'date',
                'label'          => 'Registered',
                'filter'         => false,
                'contentOptions' => ['class' => 'text-nowrap'],
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
