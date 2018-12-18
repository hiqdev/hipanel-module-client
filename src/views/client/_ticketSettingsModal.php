<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'ticket-settings-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= $form->field($model, 'ticket_emails')->hint(Yii::t('hipanel:client', 'In this field you can specify to receive email notifications of ticket. By default, the notification is used for editing the main e-mail')) ?>
    <?= $form->field($model, 'create_from_emails')->hint(Yii::t('hipanel:client', 'In this field you can specify to create ticket')) ?>
    <?= $form->field($model, 'send_message_text')->checkbox()->hint(Yii::t('hipanel:client', 'When checked, mail notification includes the text of the new message. By default, the mail has only the acknowledgment of the response and a link to the ticket. Be careful, the text can include confidential information.')) ?>
    <?= $form->field($model, 'new_messages_first')->checkbox()->hint(Yii::t('hipanel:client', 'When checked, new answers in the ticket will be displayed first.'))->label(Yii::t('hipanel:client', 'New messages first')) ?>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
