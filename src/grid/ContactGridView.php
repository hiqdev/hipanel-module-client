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
                'class'           => MainColumn::class,
                'filterAttribute' => 'name',
            ],
            'email' => [
                'format' => 'html',
                'value' => function ($model) {
                    $result = $model->email;
                    if ($model->email_new) {
                        $result .= '<br>' . Html::tag('b', Yii::t('hipanel/client', 'change is not confirmed'), ['class' => 'text-warning']);
                    }
                    if ($model->email_new !== $model->email) {
                        $result .= '<br>' . Html::tag('span', $model->email_new, ['class' => 'text-muted']);
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
                'label'  => Yii::t('hipanel/client', 'Street'),
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
                'label'  => Yii::t('hipanel/client', 'Messengers'),
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
                'class'    => ActionColumn::class,
                'template' => '{view} {update} {copy} {delete}',
                'header'   => Yii::t('hipanel', 'Actions'),
                'buttons'  => [
                    'copy'  => function ($url, $model, $key) {
                        return Html::a('<span class="fa fa-copy"></span>' . Yii::t('hipanel', 'Copy'), $url);
                    },
                    'delete' => function ($url, $model, $key) {
                        return $model->id !== $model->client_id
                            ? Html::a('<span class="fa fa-trash-o"></span>' . Yii::t('hipanel', 'Delete'), $url, [
                                'title'        => Yii::t('hipanel', 'Delete'),
                                'aria-label'   => Yii::t('hipanel', 'Delete'),
                                'data' => [
                                    'confirm' => Yii::t('hipanel/client', 'Are you sure you want to delete client {client} contact {contact}?', ['contact' => $model->name, 'client' => $model->client]),
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
