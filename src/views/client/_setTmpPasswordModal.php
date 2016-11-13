<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'tmp-password-form',
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
]) ?>

    <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
    <?= Yii::t('hipanel:client', 'Temporary password will be sent to your email') ?>

    <hr>

    <?= Html::submitButton(Yii::t('hipanel', 'Confirm'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form::end() ?>
