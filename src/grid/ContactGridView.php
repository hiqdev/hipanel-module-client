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
                'filterAttribute' => 'name',
            ],
            'email' => [
                'format' => 'html',
                'value' => function ($model) {
                    $result = $model->email;
                    if ($model->email_new) {
                        $result .= '<br><b class="text-warning">' . Yii::t('hipanel/client', 'change not confirmed') . '</b>';
                    }
                    if ($model->email_new != $model->email) {
                        $result .= '<br><span class="text-muted">' . $model->email_new . '</span>';
                    }
                    return $result;
                },
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
                'label'  => Yii::t('app', 'Street'),
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
                'attribute' => 'other_messenger',
            ],
            'messengers' => [
                'format' => 'html',
                'label'  => Yii::t('app', 'Messengers'),
                'value'  => function ($model) {
                    $res = [];
                    foreach (['skype' => 'Skype', 'icq' => 'ICQ', 'jabber' => 'Jabber'] as $k => $label) {
                        if ($model->{$k}) {
                            $res[] = "<b>$label:</b>&nbsp;" . $model->{$k};
                        }
                    }

                    return implode('<br>', $res);
                },
            ],
            'birth_date' => [
                'format' => 'date',
            ],
            'passport_date' => [
                'format' => 'date',
            ],
            'actions' => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {update} {copy} {delete}',
                'header'   => Yii::t('app', 'Actions'),
                'buttons'  => [
                    'copy'  => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-copy"></span>' . Yii::t('app', 'Copy'), $url);
                    },
                    'delete' => function ($url, $model, $key) {
                        return $model->id !== $model->client_id
                            ? Html::a('<span class="fa fa-trash-o"></span>' . Yii::t('yii', 'Delete'), $url, [
                                'title'        => Yii::t('yii', 'Delete'),
                                'aria-label'   => Yii::t('yii', 'Delete'),
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete client {client} contact {contact}?', ['contact' => $model->name, 'client' => $model->client]),
                                    'method'  => 'post',
                                    'data-pjax' => '0',
                                ],
                            ]) : '';
                    },
                ],
            ],
        ];
    }
}
