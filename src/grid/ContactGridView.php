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

use hipanel\widgets\CheckCircle;
use hiqdev\menumanager\MenuColumn;
use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\modules\client\menus\ContactActionsMenu;
use hipanel\modules\client\widgets\VerificationIndicator;
use Yii;
use yii\helpers\Html;

class ContactGridView extends BoxedGridView
{
    public static function defaultColumns()
    {
        return [
            'name' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'extraAttribute' => 'organization',
                'format' => 'raw',
            ],
            'name_v' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'extraAttribute' => 'organization',
                'format' => 'raw',
                'value' => function ($model) {
                    return CheckCircle::widget(['value' => $model->getVerification('name')->isVerified()]) .
                    Html::a($model->name, ['@contact/view', 'id' => $model->id], ['class' => 'text-bold']);
                },
            ],
            'email_v' => [
                'format' => 'raw',
                'attribute' => 'email',
                'value' => function ($model) {
                    return Html::mailto($model->email, $model->email) . CheckCircle::widget(['value' => $model->getVerification('email')->isVerified()]);
                },
            ],
            'voice_phone' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->voice_phone ? $model->voice_phone . CheckCircle::widget(['value' => $model->getVerification('voice_phone')->isVerified()]) : '';
                },
            ],
            'fax_phone' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->fax_phone ? $model->fax_phone . CheckCircle::widget(['value' => $model->getVerification('fax_phone')->isVerified()]) : '';
                },
            ],
            'email' => [
                'format' => 'raw',
                'value' => function ($model) {
                    $result = $model->email;
                    if ($model->email_new) {
                        $result .= '<br>' . Html::tag('b', Yii::t('hipanel:client', 'change is not confirmed'), ['class' => 'text-warning']);
                    }
                    if ($model->email_new !== $model->email) {
                        $result .= '<br>' . Html::tag('span', $model->email_new, ['class' => 'text-muted']);
                    }

                    return $result;
                },
            ],
            'email_with_verification' => [
                'label' => Yii::t('hipanel', 'Email'),
                'format' => 'raw',
                'value' => function ($model) {
                    $confirmation = $model->getVerification('email');
                    $result = $model->email;
                    if (!$confirmation->isConfirmed()) {
                        $result .= '<br>' . Html::tag('b', Yii::t('hipanel:client', 'change is not confirmed'), ['class' => 'text-warning']);
                        $result .= '<br>' . Html::tag('span', $model->email_new, ['class' => 'text-muted']);
                    }

                    $result .= VerificationIndicator::widget(['model' => $confirmation]);

                    return $result;
                },
            ],
            'country' => [
                'attribute' => 'country_name',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', '',
                        ['class' => 'flag-icon flag-icon-' . $model->country]) . '&nbsp;&nbsp;' . $model->country_name;
                },
            ],
            'street' => [
                'label' => Yii::t('hipanel:client', 'Street'),
                'format' => 'html',
                'value' => function ($model) {
                    return $model->street1 . $model->street2 . $model->street3;
                },
            ],
            'street1' => [
                'attribute' => 'street1',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', $model->street1, ['class' => 'bold']);
                },
            ],
            'street2' => [
                'attribute' => 'street2',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', $model->street2, ['class' => 'bold']);
                },
            ],
            'street3' => [
                'attribute' => 'street3',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::tag('span', $model->street3, ['class' => 'bold']);
                },
            ],
            'other' => [
                'attribute' => 'other_messenger',
            ],
            'messengers' => [
                'format' => 'html',
                'label' => Yii::t('hipanel:client', 'Messengers'),
                'value' => function ($model) {
                    $res = [];
                    foreach (['skype' => 'Skype', 'icq' => 'ICQ', 'jabber' => 'Jabber'] as $k => $label) {
                        if ($model->{$k}) {
                            $res[] = "<b>$label:</b>&nbsp;" . $model->{$k};
                        }
                    }

                    return implode('<br>', $res);
                },
            ],
            'social_net' => [
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->social_net, $model->social_net);
                },
            ],
            'birth_date' => [
                'format' => 'date',
            ],
            'passport_date' => [
                'format' => 'date',
            ],
            'actions' => [
                'class' => MenuColumn::class,
                'menuClass' => ContactActionsMenu::class,
            ],
            'vat_rate' => [
                'value' => function ($model) {
                    return $model->vat_rate ? (int)$model->vat_rate . '%' : null;
                },
            ],
            'reg_data' => [
                'format' => 'html',
                'value' => function ($model) {
                    return nl2br($model->reg_data);
                },
            ],
        ];
    }
}
