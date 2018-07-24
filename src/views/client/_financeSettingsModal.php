<?php

use hipanel\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'finance-settings-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= $form->field($model, 'finance_emails')->label(Yii::t('hipanel:client', 'Financial emails')) ?>

    <?php if (count($model->purses) > 1) : ?>
        <?php
        $currencies = $this->context->getCurrencyTypes();
        $purses = array_map(function ($k) {
            return $k->currency;
        }, $model->purses);

        $currencies = array_filter(
            array_combine(array_keys($currencies), array_map(function ($k) {
                return StringHelper::getCurrencySymbol($k);
            }, array_keys($currencies))), function ($k) use ($purses) {
            return in_array($k, $purses, true);
        }, ARRAY_FILTER_USE_KEY);
        ?>

        <?= $form->field($model, 'autoexchange_enabled')->checkbox()->hint(Yii::t('hipanel:client', 'When checked, ....'))->label(Yii::t('hipanel:client', 'Allow exchange currency')) ?>

        <?= $form->field($model, 'autoexchange_to')->dropDownList($currencies)->label(Yii::t('hipanel:client', 'Exchange minus balance to currency')) ?>

        <?php if (Yii::$app->user->can('manage')) : ?>
            <?= $form->field($model, 'autoexchange_force')->checkbox()->hint(Yii::t('hipanel:client', 'When checked, ....'))->label(Yii::t('hipanel:client', 'Allow force exchange currency')) ?>
        <?php endif ?>
    <?php endif ?>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
