<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="callout callout-default">
    <?= Yii::t('app', 'Enter comma separated list of IP-addresses or subnets.') ?><br>
    <?= Yii::t('app', 'Example: 88.208.52.222, 213.174.0.0/16') ?><br><br>
    <?= Yii::t('app', 'Your current IP address is {ip}', ['ip' => Yii::$app->request->getUserIp()]) ?><br>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>
<?= Html::activeHiddenInput($model, "[$model->id]id"); ?>
<?= $form->field($model, "[$model->id]allowed_ips"); ?>
<?= $form->field($model, "[$model->id]sshftp_ips")->hint(Yii::t('app', "All of accounts in the hosting panel will use following permit IP addresses list by default.
You can reassign permitted IP addresses for each account individually in it's settings.")); ?>

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>
