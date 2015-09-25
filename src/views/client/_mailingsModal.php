<?php

use hipanel\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'mailing-settings';

?>

<?php Modal::begin([
    'id' => $model->scenario . '_id',
    'size' => Modal::SIZE_DEFAULT,
    'header' => Html::tag('h4', Yii::t('app', 'Mailing settings'), ['class' => 'modal-title']),
    'toggleButton' => [
        'tag' => 'a',
        'label' => '<i class="ion-at"></i>' . Yii::t('app', 'Mailing settings'),
        'class' => 'clickable',
    ],
]); ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => false])); ?>

<?php $form = ActiveForm::begin([
    'action' => Url::to('@client/mailing-settings'),
    'options' => ['data-pjax' => '1'],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>

<div class="row">
    <div class="col-md-6">
        <fieldset>
            <legend><?= Yii::t('app', 'System notifications'); ?></legend>
            <?= $form->field($model, 'notify_important_actions')->checkbox(); ?>
            <?= $form->field($model, 'domain_registration')->checkbox(); ?>
            <?= $form->field($model, 'send_expires_when_autorenewed')->checkbox(); ?>
        </fieldset>
    </div>
    <!-- /.col-md-6 -->
    <div class="col-md-6">
        <fieldset>
            <legend><?= Yii::t('app', 'Mailings'); ?></legend>
            <?= $form->field($model, 'newsletters')->checkbox(); ?>
            <?= $form->field($model, 'commercial')->checkbox(); ?>
        </fieldset>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>
<?php Pjax::end() ?>
<?php Modal::end(); ?>
