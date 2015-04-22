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
            ],
            'province_name'=> [
                'attribute'             => 'province',
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
            ],
            'fax_phone' => [
                'attribute'             => 'fax_phone',
            ],
            'email'     => [
                'attribute'             => 'email',
            ],
            'abuse_email'=> [
                'attribute'             => 'abuse_email',
            ],
            'skype'     => [
                'attribute'             => 'skype',
            ],
            'jabber'    => [
                'attribute'             => 'jabber',
            ],
            'icq'       => [
                'attribute'             => 'icq',
            ],
        ];
    }
}
