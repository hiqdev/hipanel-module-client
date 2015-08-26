<?php

use hipanel\helpers\Url;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'client-form',
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? 'create' : 'update']),
]);
?>

<?= $form->field($model, "client")->textInput() ?>
<?= $form->field($model, "email")->textInput() ?>
<?= $form->field($model, "password")->widget(PasswordInput::className()) ?>
<?= $form->field($model, "seller_id")->widget(SellerCombo::classname()) ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
    &nbsp;
<?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php $form::end() ?>