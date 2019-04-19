<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\BoxedGridView;
use hipanel\grid\MainColumn;
use hipanel\modules\client\menus\ContactActionsMenu;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\widgets\UnverifiedWidget;
use hipanel\modules\document\widgets\StackedDocumentsView;
use hipanel\widgets\VerificationMark;
use hiqdev\yii2\menus\grid\MenuColumn;
use Yii;
use yii\helpers\Html;

class ContactGridView extends BoxedGridView
{
    public function columns()
    {
        return array_merge(parent::columns(), [
            'name' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'extraAttribute' => 'organization',
                'format' => 'raw',
            ],
            'name_with_verification' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'label' => Yii::t('hipanel', 'Name'),
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->name . VerificationMark::widget(['model' => $model->getVerification('name')]);
                },
            ],
            'name_link_with_verification' => [
                'class' => MainColumn::class,
                'filterAttribute' => 'name_like',
                'extraAttribute' => 'organization',
                'label' => Yii::t('hipanel', 'Name'),
                'format' => 'raw',
                'value' => function ($model) {
                    return VerificationMark::widget(['model' => $model->getVerification('name')]) .
                    Html::a($model->name, ['@contact/view', 'id' => $model->id], ['class' => 'text-bold']);
                },
            ],
            'email_link_with_verification' => [
                'format' => 'raw',
                'attribute' => 'email',
                'label' => Yii::t('hipanel', 'Email'),
                'value' => function ($model) {
                    return UnverifiedWidget::widget([
                        'model' => $model,
                        'attribute' => 'email',
                        'confirmedAttribute' => 'email_new',
                        'checkPermissionsForConfirmedValue' => true,
                        'tag' => 'mailto',
                    ]);
                },
            ],
            'voice_phone' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return UnverifiedWidget::widget([
                        'model' => $model,
                        'attribute' => 'voice_phone',
                    ]);
                },
            ],
            'fax_phone' => [
                'format' => 'raw',
                'value' => function ($model) {
                    return UnverifiedWidget::widget([
                        'model' => $model,
                        'attribute' => 'fax_phone',
                    ]);
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
                    return UnverifiedWidget::widget([
                        'model' => $model,
                        'attribute' => 'email',
                        'confirmedAttribute' => 'email_new',
                        'checkPermissionsForConfirmedValue' => true,
                    ]);
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
                'label' => Yii::t('hipanel:client', 'Address'),
                'format' => 'html',
                'value' => function ($model) {
                    return $model->street1 . $model->street2 . $model->street3 .
                        VerificationMark::widget(['model' => $model->getVerification('address')]);
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
            ],
            'social_net' => [
                'format' => 'html',
                'value' => function ($model) {
                    $url = $model->social_net;

                    return filter_var($url, FILTER_VALIDATE_URL) ? "<a href=\"$url\">$url</a>" : $url;
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
            'tin_number' => [
                'attribute' => 'vat_number',
                'label'     => Yii::t('hipanel:client', 'TIN number'),
            ],
            'vat_rate' => [
                'value' => function ($model) {
                    return $model->vat_rate ? (int) $model->vat_rate . '%' : null;
                },
            ],
            'reg_data' => [
                'format' => 'html',
                'value' => function ($model) {
                    return nl2br($model->reg_data);
                },
            ],
            'bank_account' => [
                'format' => 'html',
                'value' => function ($model) {
                    return nl2br($model->bank_account);
                },
            ],
            'documents' => [
                'format' => 'raw',
                'label' => Yii::t('hipanel:client', 'Documents'),
                'value' => function ($model) {
                    if (Yii::getAlias('@documents', false) === null) {
                        return '';
                    }

                    if (!Yii::$app->user->can('document.read')) {
                        return '';
                    }

                    return StackedDocumentsView::widget([
                        'models' => $model->documents,
                    ]);
                },
            ],
            'requisites' => [
                'format' => 'html',
                'value' => function ($model) {
                    $res = implode("\n", array_filter([
                        $model->organization,
                        $model->renderAddress(),
                        $model->vat_number,
                        $model->invoice_last_no,
                    ])) . "\n\n";
                    $res .= $model->renderBankDetails();

                    return nl2br($res);
                },
            ],
        ]);
    }
}
