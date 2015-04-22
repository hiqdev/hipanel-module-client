<?php
/**
 * @link    http://hiqdev.com/hipanel-module-domain
 * @license http://hiqdev.com/hipanel-module-domain/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\grid;

use hipanel\modules\client\widgets\State as ClientState;
use hipanel\modules\client\widgets\Type as ClientType;
use hipanel\grid\BoxedGridView;
use hipanel\grid\RefColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\SwitchColumn;
use hipanel\grid\EditableColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\helpers\Html;

class ClientGridView extends BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'id'        => [
                'class'                 => ClientColumn::className(),
                'attribute'             => 'id',
                'nameAttribute'         => 'login',
                'label'                 => 'Client',
            ],
            'state'         => [
                'class'                 => RefColumn::className(),
                'format'                => 'raw',
                'gtype'                 => 'state,client',
                'value'                 => function ($model) {
                    return ClientState::widget(compact('model'));
                }
            ],
            'type'          => [
                'class'                 => RefColumn::className(),
                'format'                => 'raw',
                'gtype'                 => 'type,client',
                'value'                 => function ($model) {
                    return ClientType::widget(compact('model'));
                }
            ],
            'balance'       => [
                'attribute'             => 'balance',
                'format'                => 'html',
                'filter'                => false,
                'value'                 => function ($model) {
                    return HTML::tag('span', $model->balance, [ 'class' => 'label label-' . ($model->balance < 0 ? ($model->balance + $model->credit < 0 ? 'danger' : 'warning') : 'info')]);
                },
            ],
            'credit'        => [
                'class' => EditableColumn::className(),
                'attribute'             => 'credit',
                'filter'                => false,
                'popover'               => Yii::t('app','Make any notes for your convenience'),
                'action'                => ['set-credit'],
            ],
            'create_time'   => [
                'attribute'             => 'create_time',
                'format'                => 'date',
                'label'                 => 'Registered',
                'filter'                => false,
                'contentOptions'        => ['class' => 'text-nowrap'],
            ],
        ];
    }
}
