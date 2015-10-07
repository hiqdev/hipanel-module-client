<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="callout callout-default">
    <?= Yii::t('app', 'Enter comma separated list of IP-addresses or subnets.') ?><br>
    <?= Yii::t('app', 'Example') ?>: 88.208.52.222, 213.174.0.0/16<br><br>
    <?= Yii::t('app', 'Your current IP address is') ?> <?= Yii::$app->request->getUserIp() ?><br>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

<?= $form->field($model, 'allowed_ips'); ?>
<?= $form->field($model, 'sshftp_ips')->hint("All of accounts in the hosting panel will use following permit IP addresses list by default.
You can reassign permitted IP addresses for each account individually in it's settings."); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>
