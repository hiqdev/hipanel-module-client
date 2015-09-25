<?php

use hipanel\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'ip-restrictions';

?>

<?php Modal::begin([
    'id' => $model->scenario . '_id',
    'size' => Modal::SIZE_DEFAULT,
    'header' => Html::tag('h4', Yii::t('app', 'Setup IP address restrictions'), ['class' => 'modal-title']),
    'toggleButton' => [
        'tag' => 'a',
        'label' => '<i class="ion-network"></i>' . Yii::t('app', 'Setup IP address restrictions'),
        'class' => 'clickable',
    ],
]); ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => false])); ?>

    <div class="callout callout-default">
        Enter comma separated list of IP-addresses or subnets.<br>
        Example: 88.208.52.222, 213.174.0.0/16<br>
        Your current IP address is 88.208.49.170<br>
    </div>

<?php $form = ActiveForm::begin([
    'action' => Url::to('@client/mailing-settings'),
    'options' => ['data-pjax' => '1'],
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
<?php Pjax::end() ?>
<?php Modal::end(); ?>