<?php

use hipanel\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'change-password';

?>

<?php Modal::begin([
    'id' => $model->scenario . '_id',
    'size' => Modal::SIZE_DEFAULT,
    'header' => Html::tag('h4', Yii::t('app', 'Change password'), ['class' => 'modal-title']),
    'toggleButton' => [
        'tag' => 'a',
        'label' => '<i class="ion-unlocked"></i>' . Yii::t('app', 'Change password'),
        'class' => 'clickable',
    ],
]); ?>
<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => false])); ?>

<?php $form = ActiveForm::begin([
    'action' => Url::to('@client/mailing-settings'),
    'options' => ['data-pjax' => '1'],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

<?= $form->field($model, 'login')->textInput(['readonly' => 'readonly']); ?>
<?= $form->field($model, 'cpassword')->passwordInput(); ?>
<?= $form->field($model, 'password')->widget(\hipanel\widgets\PasswordInput::className()); ?>
<?= $form->field($model, 'repassword'); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>
<?php Pjax::end() ?>
<?php Modal::end(); ?>