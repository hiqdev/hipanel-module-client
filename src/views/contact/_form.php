<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\BackButton;
use hipanel\widgets\Box;
use hipanel\widgets\DatePicker;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

/**
 * @var string $scenario
 * @var array $countries
 * @var \hipanel\modules\client\models\Contact $model
 * @var \yii\bootstrap\ActiveForm $form
 */
?>

<div class="row">
    <?= Html::activeHiddenInput($model, 'pincode'); ?>

    <div class="col-md-12">
        <?php Box::begin(); ?>
        <?php if ($model->scenario === 'update') : ?>
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
        <?php else : ?>
            <?= Html::submitButton(Yii::t('hipanel:client', 'Create contact'), ['class' => 'btn btn-success']); ?>
        <?php endif; ?>
        <?= BackButton::widget() ?>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin(['title' => Yii::t('hipanel:client', 'Contact details')]) ?>
        <?php if ($model->scenario === 'update') : ?>
            <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
        <?php else: ?>
            <?= $form->field($model, 'client_id')->widget(ClientCombo::class); ?>
        <?php endif; ?>

        <?= $form->field($model, 'first_name'); ?>
        <?= $form->field($model, 'last_name'); ?>
        <?= $form->field($model, 'email'); ?>
        <?= Html::activeHiddenInput($model, 'oldEmail', ['value' => $model->oldAttributes['email'] ?: $model->oldEmail]) ?>

        <?= $form->field($model, 'abuse_email'); ?>
        <?= $form->field($model, 'organization'); ?>
        <?= $form->field($model, 'street1'); ?>
        <?= $form->field($model, 'street2'); ?>
        <?= $form->field($model, 'street3'); ?>
        <?= $form->field($model, 'city'); ?>
        <?= $form->field($model, 'country')->widget(StaticCombo::class, [
            'data' => $countries,
            'hasId' => true,
        ]); ?>
        <?= $form->field($model, 'province'); ?>
        <?= $form->field($model, 'postal_code'); ?>
        <?= $form->field($model, 'voice_phone'); ?>
        <?= $form->field($model, 'fax_phone'); ?>

        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsable' => true,
            'title' => Yii::t('hipanel:client', 'Additional contacts'),
        ]) ?>
        <?= $form->field($model, 'icq'); ?>
        <?= $form->field($model, 'skype'); ?>
        <?= $form->field($model, 'jabber'); ?>
        <?= $form->field($model, 'other_messenger'); ?>
        <?= $form->field($model, 'social_net'); ?>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsed' => true,
            'title' => Yii::t('hipanel:client', 'Passport data'),
        ]) ?>
        <fieldset id="fiz_domain">
            <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                'removeButton' => false,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd', // TODO: get format from user settings
                    'autoclose' => true,
                    'clearBtn' => true,
                ],
                'options' => [
                    'readonly' => 'readonly',
                    'class' => 'datepicker',
                    'placeholder' => Yii::t('hipanel', 'Select date'),
                ],
            ]); ?>
            <?= $form->field($model, 'passport_no'); ?>
            <?= $form->field($model, 'passport_date')->widget(DatePicker::class, [
                'removeButton' => false,
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',  // TODO: get format from user settings
                    'autoclose' => true,
                    'clearBtn' => true,
                ],
                'options' => [
                    'readonly' => 'readonly',
                    'class' => 'datepicker',
                    'placeholder' => Yii::t('hipanel', 'Select date'),
                ],
            ]); ?>
            <?= $form->field($model, 'passport_by'); ?>
        </fieldset>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsed' => true,
            'title' => Yii::t('hipanel:client', 'Legal entity information'),
        ]) ?>
        <fieldset id="jur_domain">
            <?= $form->field($model, 'organization_ru'); ?>
            <?= $form->field($model, 'director_name'); ?>
            <?= $form->field($model, 'inn'); ?>
            <?= $form->field($model, 'kpp'); ?>
            <?= $form->field($model, 'isresident')->checkbox(); ?>
        </fieldset>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsed' => true,
            'title' => Yii::t('hipanel:client', 'Registration data')
        ]) ?>
        <fieldset id="tax_info">
            <?= $form->field($model, 'vat_number')->textArea() ?>
            <?= $form->field($model, 'vat_rate') ?>
        </fieldset>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsed' => true,
            'title' => Yii::t('hipanel:client', 'Bank details')
        ]) ?>
        <fieldset id="bank_info">
            <?= $form->field($model, 'bank_account')->textArea() ?>
            <?= $form->field($model, 'bank_name') ?>
            <?= $form->field($model, 'bank_address') ?>
            <?= $form->field($model, 'bank_swift') ?>
        </fieldset>
        <?php Box::end() ?>
    </div>
</div>
<!-- /.row -->
