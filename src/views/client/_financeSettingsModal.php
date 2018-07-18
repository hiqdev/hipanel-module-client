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

    <?php
    $currencies = $this->context->getCurrencyTypes();
    $currencies = array_combine(array_keys($currencies), array_map(function ($k) {
        return StringHelper::getCurrencySymbol($k);
    }, array_keys($currencies)));
    ?>

    <?= $form->field($model, 'autoexchange_enabled')->checkbox()->hint(Yii::t('hipanel:client', 'When checked, ....'))->label(Yii::t('hipanel:client', 'Allow exchange currency')) ?>

    <?= $form->field($model, 'autoexchange_to')->dropDownList($currencies)->label(Yii::t('hipanel:client', 'Exchange minus balance to currency')) ?>

    <?php if (Yii::$app->user->can('manage')) : ?>
        <?= $form->field($model, 'autoexchange_force')->checkbox()->hint(Yii::t('hipanel:client', 'When checked, ....'))->label(Yii::t('hipanel:client', 'Allow force exchange currency')) ?>
    <?php endif ?>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
