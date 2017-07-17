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

<?php if ($model->isNewRecord) : ?>
    <?= $form->field($model, '[0]login')->textInput(['autocomplete' => 'new-login']) ?>
    <?= $form->field($model, '[0]email')->textInput(['autocomplete' => 'new-email']) ?>
    <?= $form->field($model, '[0]password')->widget(PasswordInput::class) ?>
<?php else: ?>
    <?= $form->field($model, '[0]id')->hiddenInput()->label(false) ?>
<?php endif; ?>

<?= $form->field($model, '[0]type')->dropDownList(Client::getTypeOptions()) ?>
<?= $form->field($model, '[0]seller_id')->widget(SellerCombo::class, [
    'pluginOptions' => [
        'select2Options' => [
            'templateSelection' => new \yii\web\JsExpression("
                function (data, container) { 
                    var disVal = '{$model->seller}'; 
                    if ( container ) {
                        return data.text; 
                    } else {
                        $('#client-0-seller_id').attr('disabled', true);
                        return disVal;
                    }
                }
            ")
        ]
    ],
]) ?>

<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
&nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
<?php $form->end() ?>
