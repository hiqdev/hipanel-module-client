<?php

use borales\extensions\phoneInput\PhoneInput;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\BackButton;
use hipanel\widgets\Box;
use hipanel\widgets\DateTimePicker;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var string
 * @var array $countries
 * @var \hipanel\modules\client\models\Contact $model
 * @var \yii\bootstrap\ActiveForm $form
 */
?>

<div class="row">
    <div class="col-md-12">
        <?php Box::begin(['options' => ['class' => 'box-widget']]); ?>
        <?php if ($model->scenario === 'create') : ?>
            <?= Html::submitButton(Yii::t('hipanel:client', 'Create contact'), ['class' => 'btn btn-success']); ?>
        <?php else : ?>
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
        <?php endif; ?>
        <?= BackButton::widget() ?>
        <?php Box::end(); ?>
        <?= Html::hiddenInput('pincode', null, ['id' => 'contact-pincode']) ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin(['title' => Yii::t('hipanel:client', 'Contact details')]) ?>
        <?php if ($model->scenario !== 'create') : ?>
            <?= $form->field($model, 'id')->hiddenInput()->label(false); ?>
        <?php elseif (Yii::$app->user->can('support')) : ?>
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
        <?= $form->field($model, 'voice_phone')->widget(PhoneInput::class, [
            'jsOptions' => [
                'preferredCountries' => array_values(array_unique(array_filter([$model->country, 'us', 'ru', 'ua', 'gb']))),
                'initialCountry' => 'auto',
            ],
        ]) ?>
        <?= $form->field($model, 'fax_phone')->widget(PhoneInput::class, [
            'jsOptions' => [
                'preferredCountries' => array_values(array_unique(array_filter([$model->country, 'us', 'ru', 'ua', 'gb']))),
                'initialCountry' => 'auto',
            ],
        ]) ?>
        <?= $form->field($model, 'xxx_token'); ?>

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
        <?= $form->field($model, 'viber'); ?>
        <?= $form->field($model, 'telegram'); ?>
        <?= $form->field($model, 'whatsapp'); ?>
        <?= $form->field($model, 'other_messenger'); ?>
        <?= $form->field($model, 'social_net'); ?>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsed' => !in_array($model->scenario, ['create-require-passport', 'update-require-passport', 'create-ru-contact', 'update-ru-contact'], true)
                && empty($model->birth_date) && empty($model->passport_no)
                && empty($model->passport_date) && empty($model->passport_by)
                && empty($model->organization),
            'collapsable' => true,
            'title' => Yii::t('hipanel:client', 'Passport data'),
            'options' => [
                'id' => 'passport-data-box',
            ],
        ]) ?>
        <fieldset id="fiz_domain">
            <?= $form->field($model, 'birth_date')->widget(DateTimePicker::class, [
                'clientOptions' => [
                    'format' => 'yyyy-mm-dd', // TODO: get format from user settings
                    'autoclose' => true,
                    'clearBtn' => true,
                    'minView' => 2,
                ],
                'options' => [
                    'readonly' => 'readonly',
                    'class' => 'DateTimePicker',
                    'placeholder' => Yii::t('hipanel', 'Select date'),
                ],
            ]); ?>
            <?= $form->field($model, 'passport_no'); ?>
            <?= $form->field($model, 'passport_date')->widget(DateTimePicker::class, [
                'clientOptions' => [
                    'format' => 'yyyy-mm-dd',  // TODO: get format from user settings
                    'autoclose' => true,
                    'clearBtn' => true,
                    'minView' => 2,
                ],
                'options' => [
                    'readonly' => 'readonly',
                    'class' => 'DateTimePicker',
                    'placeholder' => Yii::t('hipanel', 'Select date'),
                ],
            ]); ?>
            <?= $form->field($model, 'passport_by'); ?>
        </fieldset>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php Box::begin([
            'collapsed' => !in_array($model->scenario, ['create-require-organization', 'update-require-organization', 'create-ru-contact', 'update-ru-contact'], true)
                && empty($model->organization_ru) && empty($model->director_name) && empty($model->organization)
                && empty($model->kpp) && empty($model->inn),
            'collapsable' => true,
            'title' => Yii::t('hipanel:client', 'Legal entity information'),
            'options' => [
                'id' => 'legal-entity-box',
            ],
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
            'title' => Yii::t('hipanel:client', 'Registration data'),
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
            'title' => Yii::t('hipanel:client', 'Bank details'),
        ]) ?>
        <fieldset id="bank_info">
            <?= $form->field($model, 'bank_account')->textArea() ?>
            <?= $form->field($model, 'bank_name') ?>
            <?= $form->field($model, 'bank_address') ?>
            <?= $form->field($model, 'bank_swift') ?>
            <?= $form->field($model, 'bank_correspondent') ?>
            <?= $form->field($model, 'bank_correspondent_swift') ?>
        </fieldset>
        <?php Box::end() ?>
    </div>

    <div class="col-md-12">
        <?php Box::begin(['options' => ['class' => 'box-widget']]); ?>
        <?php if ($model->scenario === 'create') : ?>
            <?= Html::submitButton(Yii::t('hipanel:client', 'Create contact'), ['class' => 'btn btn-success']); ?>
        <?php else : ?>
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
        <?php endif; ?>
        <?= BackButton::widget() ?>
        <?php Box::end(); ?>
    </div>
</div>
<!-- /.row -->

<?php

$this->registerJs(<<<JS

jQuery('#contact-organization').on('change', function() {
    var triggerInput = function(selector, disable) {
        jQuery(selector + ' input').each(function(i, e) {
            if (disable == true) {
                jQuery(this).prop('disabled', 'disabled');
            } else {
                jQuery(this).prop('disabled', false);
            }
        });

        if (disable == true) {
            jQuery(selector).prop('disabled', disable);
        } else {
            jQuery(selector).prop('disabled', false);
        }
    }

    if (!jQuery(this).val()) {
        jQuery('#passport-data-box').removeClass('collapsed-box');
        jQuery('#legal-entity-box').addClass('collapsed-box');
        triggerInput('#fiz_domain', false);
        triggerInput('#jur_domain', true);
        return false;
    }

    jQuery('#passport-data-box').addClass('collapsed-box');
    jQuery('#legal-entity-box').removeClass('collapsed-box');
    triggerInput('#fiz_domain', true);
    triggerInput('#jur_domain', false);
});

jQuery('#contact-organization').trigger('change');
JS
    , View::POS_READY);
?>
