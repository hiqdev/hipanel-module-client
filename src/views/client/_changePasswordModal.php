<?php

use hipanel\widgets\PasswordInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
    <?= $form->field($model, "[$model->id]login")->textInput(['readonly' => 'readonly']) ?>
    <?= $form->field($model, "[$model->id]old_password")->passwordInput() ?>
    <?= $form->field($model, "[$model->id]new_password")->widget(PasswordInput::class, [
        'id' => $model->id . '_change-password-modal',
    ]) ?>
    <?= $form->field($model, "[$model->id]confirm_password")->passwordInput() ?>

    <hr>

    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form::end() ?>
