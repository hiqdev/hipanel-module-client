<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'mailing-settings-form',
    ],
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
