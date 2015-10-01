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
]); ?>

<p><?= Yii::t('app', 'This section allows you to manage the settings on mail alerts'); ?></p>

<p><?= Yii::t('app', 'In this field you can specify to receive email notifications of ticket. By default,
the notification is used for editing the main e-mail'); ?></p>

<?= $form->field($model, 'ticket_emails'); ?>
<p>
    <?= Yii::t('app', 'If you check in the mail notification will include the text of the new message in the ticket.
                By default, the mail comes only acknowledgment of receipt of the ticket and a link to the ticket.
                WARNING! The text can include confidential information and data access'); ?>
</p>

<?= $form->field($model, 'send_message_text')->checkbox(); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form->end(); ?>
