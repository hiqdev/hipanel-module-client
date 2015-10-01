<?php

use hipanel\widgets\PasswordInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'change-password';

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

<?= $form->field($model, 'login')->textInput(['readonly' => 'readonly']); ?>
<?= $form->field($model, 'cpassword')->passwordInput(); ?>
<?= $form->field($model, 'password')->widget(PasswordInput::className()); ?>
<?= $form->field($model, 'repassword'); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>