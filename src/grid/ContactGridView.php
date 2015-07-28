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

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use Yii;
use yii\helpers\Html;

class ContactGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'name' => [
                'class'           => MainColumn::className(),
                'filterAttribute' => 'name_like',
            ],
            'country' => [
                'attribute' => 'country_name',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::tag('span', '',
                        ['class' => 'flag-icon flag-icon-' . $model->country]) . '&nbsp;&nbsp;' . $model->country_name;
                },
            ],
            'street' => [
                'format' => 'html',
                'value'  => function ($model) {
                    return $model->street1 . $model->street2 . $model->street3;
                },
            ],
            'street1' => [
                'attribute' => 'street1',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::tag('span', $model->street1, ['class' => 'bold']);
                },
            ],
            'street2' => [
                'attribute' => 'street2',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::tag('span', $model->street2, ['class' => 'bold']);
                },
            ],
            'street3' => [
                'attribute' => 'street3',
                'format'    => 'html',
                'value'     => function ($model) {
                    return Html::tag('span', $model->street3, ['class' => 'bold']);
                },
            ],
            'other' => [
                'value'     => function ($model) {
                    return $model->other_messenger;
                },
            ],
            'messengers' => [
                'format' => 'html',
                'value' => function ($model) {
                    foreach (['skype' => 'Skype', 'icq' => 'ICQ', 'jabber' => 'Jabber'] as $k => $label) {
                        $res[] = $model->{$k} ? "<b>$label:</b>&nbsp;" . $model->{$k} : '';
                    }
                    return implode('<br>',$res);
                },
            ],
            'birth_date' => [
                'format'    => 'date',
            ],
            'passport_date' => [
                'format'    => 'date',
            ],
            'action' => [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {copy}',
                'buttons'  => [
                    'copy' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-copy"></span>', ['view', 'id' => $model['id']]);
                    },
                ],
            ],
        ];
    }
}
