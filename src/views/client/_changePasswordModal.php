<?php

use hipanel\widgets\PasswordInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

<?= Html::activeHiddenInput($model, "[$model->id]id"); ?>

<?= $form->field($model, "[$model->id]login")->textInput(['readonly' => 'readonly']); ?>
<?= $form->field($model, "[$model->id]old_password")->passwordInput(); ?>
<?= $form->field($model, "[$model->id]new_password")->widget(PasswordInput::className(), [
    'id' => $model->id . '_change-password-modal'
]); ?>
<?= $form->field($model, "[$model->id]confirm_password"); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>