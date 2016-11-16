<?php

use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'client-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? 'create' : 'update']),
]);
?>

<?= $form->field($model, '[0]login')->textInput(['autocomplete' => 'off']) ?>
<?= $form->field($model, '[0]email')->textInput(['autocomplete' => 'off']) ?>
<?= $form->field($model, '[0]password')->widget(PasswordInput::class) ?>
<?= $form->field($model, '[0]type')->dropDownList(Client::getTypeOptions()) ?>
<?= $form->field($model, '[0]seller_id')->widget(SellerCombo::class) ?>

<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
    &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php $form->end() ?>
