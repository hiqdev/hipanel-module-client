<?php

use hipanel\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'ticket-settings';
?>

<?php Modal::begin([
    'id' => $model->scenario . '_id',
    'size' => Modal::SIZE_DEFAULT,
    'header' => Html::tag('h4', Yii::t('app', 'Ticket settings'), ['class' => 'modal-title']),
    'toggleButton' => [
        'tag' => 'a',
        'label' => '<i class="fa fa-ticket"></i>' . Yii::t('app', 'Ticket settings'),
        'class' => 'clickable',
    ],
]); ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => false])); ?>
<p><?= Yii::t('app', 'This section allows you to manage the settings on mail alerts'); ?></p>

<p><?= Yii::t('app', 'In this field you can specify to receive email notifications of ticket. By default, the notification is used for editing the main e-mail'); ?></p>

<?php
$form = ActiveForm::begin([
    'action' => Url::to('@client/ticket-settings'),
    'options' => ['data-pjax' => '1'],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]);
?>

<?= $form->field($model, 'ticket_emails'); ?>
<p>
    <?= Yii::t('app', 'If you check in the mail notification will include the text of the new message in the ticket.
                By default, the mail comes only acknowledgment of receipt of the ticket and a link to the ticket.
                WARNING! The text can include confidential information and data access'); ?>
</p>

<?= $form->field($model, 'send_message_text')->checkbox(); ?>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>

<?php $form::end(); ?>
<?php Pjax::end() ?>

<?php Modal::end(); ?>
