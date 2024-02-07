<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="callout callout-default">
    <?= Yii::t('hipanel:client', 'Enter comma separated list of IP-addresses or subnets.') ?><br>
    <?= Yii::t('hipanel', 'Example') ?>: 88.208.52.222, 213.174.0.0/16<br><br>
    <?= Yii::t('hipanel:client', 'Your current IP address is {ip}', ['ip' => Yii::$app->request->getUserIp()]) ?><br>
</div>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= Html::activeHiddenInput($model, "[$model->id]id") ?>
    <?= $form->field($model, "[$model->id]allowed_ips")->textInput(['readonly' => isset(Yii::$app->params['nope.site'])]) ?>
    <?= $form->field($model, "[$model->id]sshftp_ips")->hint(Yii::t('hipanel:client', "All of accounts in the hosting panel will use following permit IP addresses list by default. You can reassign permitted IP addresses for each account individually in it's settings.")) ?>

    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form::end() ?>
