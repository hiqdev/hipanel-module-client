<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <div class="row">
        <div class="col-md-6">
            <fieldset>
                <legend><?= Yii::t('hipanel:client', 'System notifications') ?></legend>
                <?= $form->field($model, 'notify_important_actions')->checkbox() ?>
                <?= $form->field($model, 'domain_registration')->checkbox() ?>
            </fieldset>
        </div>
        <!-- /.col-md-6 -->
        <div class="col-md-6">
            <fieldset>
                <legend><?= Yii::t('hipanel:client', 'Mailings') ?></legend>
                <?= $form->field($model, 'newsletters')->checkbox() ?>
                <?= $form->field($model, 'commercial')->checkbox() ?>
            <?php if (Yii::$app->user->can('manage')) : ?>
                <?= $form->field($model, 'monthly_invoice')->checkbox() ?>
            <?php endif ?>
            </fieldset>
        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
<?php $form::end() ?>
