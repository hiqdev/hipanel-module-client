<?php

use hipanel\modules\client\forms\ChangePaymentStatusForm;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/**
 * @var ChangePaymentStatusForm $model
 * @var ChangePaymentStatusForm[] $models
 */

?>

<?php $form = ActiveForm::begin(['id' => 'payment-status-form']); ?>

<?= Html::activeHiddenInput($model, 'id') ?>

<?php if (in_array('deny:deposit', explode(',', $model->roles))) : ?>
    <?= Html::activeHiddenInput($model, 'deny_deposit', ['value' => false]) ?>
    <?= Html::submitButton(Yii::t('hipanel:client', 'Permit merchant payments'), ['class' => 'btn btn-success btn-block']) ?>
<?php else : ?>
    <?= Html::activeHiddenInput($model, 'deny_deposit', ['value' => true]) ?>
    <?= Html::submitButton(Yii::t('hipanel:client', 'Forbid merchant payments'), ['class' => 'btn btn-danger btn-block']) ?>
<?php endif ?>

<?php ActiveForm::end() ?>
