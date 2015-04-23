<?php
/**
 * @link    http://hiqdev.com/hipanel-module-domain
 * @license http://hiqdev.com/hipanel-module-domain/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\grid;

use frontend\assets\FlagIconCssAsset;
use hipanel\grid\BoxedGridView;

use hipanel\grid\RefColumn;
use hipanel\grid\MainColumn;
use hipanel\grid\SwitchColumn;
use hipanel\grid\EditableColumn;
use hipanel\widgets\ArraySpoiler;
use Yii;
use yii\helpers\Html;

class ContactGridView extends BoxedGridView
{
    static public function defaultColumns()
    {
        return [
            'country'   => [
                'attribute'             => 'country_name',
                'format'                => 'html',
                'value'                 => function($model) {
                    return Html::tag('span', '', ['class' => 'flag-icon flag-icon-' . $model->country]) . '&nbsp;&nbsp;' . $model->country_name;
                },
            ],
            'province'  => [
                'attribute'             => 'province',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->province ?: "";
                },
            ],
            'province_name'=> [
                'attribute'             => 'province',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->province ?: "";
                },
            ],
            'postal_code'=> [
                'attribute'             => 'postal_code',
            ],
            'city'      => [
                'attribute'             => 'city',
            ],
            'street'    => [
                'format'                => 'html',
                'value'                 => function($model) {
                    return  Html::tag('span', $model->street1, [ 'class' => 'bold']) .
                        ($model->street2 ? Html::tag('span', $model->street2) : '') .
                        ($model->street3 ? Html::tag('span', $model->street3) : '');
                },
            ],
            'street1'   => [
                'attribute'             => 'street1',
                'format'                => 'html',
                'value'                 => function($model) {
                    return  Html::tag('span', $model->street1, [ 'class' => 'bold']);
                },
            ],
            'street2'   => [
                'attribute'             => 'street2',
                'format'                => 'html',
                'value'                 => function($model) {
                    return  Html::tag('span', $model->street1, [ 'class' => 'bold']);
                },
            ],
            'street3'   => [
                'attribute'             => 'street3',
                'format'                => 'html',
                'value'                 => function($model) {
                    return  Html::tag('span', $model->street3, [ 'class' => 'bold']);
                },
            ],
            'voice_phone'=> [
                'attribute'             => 'voice_phone',
            ],
            'fax'       => [
                'attribute'             => 'fax_phone',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->fax_phone ?: "";
                }
            ],
            'fax_phone' => [
                'attribute'             => 'fax_phone',
                 'format'                => 'html',
                'value'                 => function($model) {
                    return $model->fax_phone ?: "";
                }
            ],
            'email'     => [
                'attribute'             => 'email',
            ],
            'abuse_email'=> [
                'attribute'             => 'abuse_email',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->abuse_email ?: "";
                }
            ],
            'skype'     => [
                'attribute'             => 'skype',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->skype ?: "";
                }
            ],
            'jabber'    => [
                'attribute'             => 'jabber',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->jabber ?: "";
                }
            ],
            'icq'       => [
                'attribute'             => 'icq',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->icq ?: "";
                }
            ],
            'passport_no'=> [
                'attribute'             => 'passport_no',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->passport_no ?: "";
                }
            ],
            'passport_date'=> [
                'attribute'             => 'passport_date',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->passport_date ?: "";
                }
            ],
            'passport_by'=> [
                'attribute'             => 'passport_by',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->passport_by ?: "";
                }
            ],
            'organization'=> [
                'attribute'             => 'organization',
                'format'                => 'html',
                'value'                 => function($model) {
                    return $model->organization ?: "";
                }
            ],
            'action'    => [
                'class'                 => 'yii\grid\ActionColumn',
                
                'template'              => '{view} {update} {delete} {copy}',
                'buttons'               => [
                    'copy'          => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-copy"></span>', ['view','id'=>$model['id']]);
                    },
                ],
            ],
        ];
    }
}