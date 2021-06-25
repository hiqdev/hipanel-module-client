<?php

use hipanel\widgets\CustomAttributesForm;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use hipanel\modules\client\models\Client;

/**
 * @var Client $model
 */

?>

<?php $form = ActiveForm::begin([
    'id' => 'set-attributes-form',
    'action' => 'update',
]) ?>

<?= Html::activeHiddenInput($model, "[$model->id]id") ?>

<?= CustomAttributesForm::widget(['form' => $form, 'owner' => $model]) ?>

<?= Html::submitButton(Yii::t('hipanel', 'Confirm'), ['class' => 'btn btn-success']) ?> &nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form::end() ?>
