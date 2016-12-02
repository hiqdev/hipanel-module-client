<?php

use hipanel\widgets\Box;
use hipanel\widgets\DatePicker;
use hiqdev\combo\StaticCombo;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use hipanel\widgets\BackButton;

$this->registerJs(<<<JS
jQuery('#fiz_domain input').change(function() {
    var disable = false;
    jQuery('#fiz_domain input').each(function(i, e) {
        var elem = jQuery(e);
        if (elem.prop('type') == 'text' && elem.val() != '') {
            disable = true;
        }
    });
    jQuery('#jur_domain').prop('disabled', disable);
});
jQuery('#jur_domain input').change(function() {
    var disable = false;
    jQuery('#jur_domain input').each(function(i, e) {
        var elem = jQuery(e);
        if ((elem.prop('type') == 'checkbox' && elem.is(':checked')) || (elem.prop('type') == 'text' && elem.val() != '')) {
            disable = true;
        }
    });
    jQuery('#contact-passport_date, #contact-birth_date').each(function(i, e) {
        var elem = jQuery(e);
        var opts = elem.data('krajee-datepicker');
        if (disable) {
            elem.parent().kvDatepicker('remove');
            elem.parent().addClass('disabled');
        } else {
            elem.parent().kvDatepicker(opts);
            elem.parent().removeClass('disabled');
        }
    });
    jQuery('#fiz_domain').prop('disabled', disable);
});
JS
, View::POS_READY);
?>

<?php if ($askPincode['pincode_enabled']) : ?>
    <?php $this->registerJs(<<<"JS"
    var oldEmail = document.getElementById('contact-oldemail').value;
    var show = true;
    jQuery('#contact-form').on('beforeSubmit', function(event, attributes, messages, deferreds) {
        if (attributes === undefined) {
            attributes = document.getElementById('contact-form').elements; 
        }
        for (var attr in attributes) {
            var attribute = attributes[attr]; 
            if (attribute.length == 0) {
                show = false;
                return;
            }
            if (attribute.name === 'Contact[email]') {
                if (attribute.value === oldEmail) {
                    show = false;
                }
            }
        }
        if (show) {
            event.preventDefault();
            jQuery('#askpincode-modal').modal('show');
            return false;
        }
    });
    if (show) {
        jQuery('#modal-ask-pincode-button').on('click', function(e) {
            var pincode = jQuery('#modal-pincode').val();
            jQuery('#contact-pincode').val(pincode);
            document.getElementById("contact-form").submit();
        });
    }
JS
    ); ?>
    <?php Modal::begin([
        'id' => 'askpincode-modal',
        'size' => Modal::SIZE_SMALL,
        'header' => '<h4 class="modal-title">' . Yii::t('hipanel:client', 'Enter pincode') . '</h4>',
        'clientEvents' => [
            'show.bs.modal' => new JsExpression("function() {document.getElementById('modal-pincode').value = '';}"),
        ],
        'footer' => Html::submitButton(Yii::t('hipanel', 'Submit'), [
            'id' => 'modal-ask-pincode-button',
            'class' => 'btn btn-default btn-loading',
            'data-loading-text' => Yii::t('hipanel', 'loading...'),
            'data-loading-icon' => 'glyphicon glyphicon-refresh',
        ]),
    ]); ?>
    <?= Html::textInput('modal-pincode', null, ['id' => 'modal-pincode', 'class' => 'form-control', 'placeholder' => Yii::t('hipanel:client', 'Type pincode here...')]); ?>
    <?php Modal::end(); ?>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'action' => $model->scenario === 'copy' ? Url::toRoute('create') : $model->scenario,
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'layout' => 'horizontal',
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

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
        <?php endif; ?>
        <?= $form->field($model, 'first_name'); ?>
        <?= $form->field($model, 'last_name'); ?>
        <?= $form->field($model, 'email'); ?>
        <?= Html::activeHiddenInput($model, 'oldEmail', ['value' => $model->oldAttributes['email'] ? : $model->oldEmail]) ?>

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
        <?php Box::begin(['title' => Yii::t('hipanel:client', 'Additional contacts')]) ?>
        <?= $form->field($model, 'icq'); ?>
        <?= $form->field($model, 'skype'); ?>
        <?= $form->field($model, 'jabber'); ?>
        <?= $form->field($model, 'other_messenger'); ?>
        <?= $form->field($model, 'social_net'); ?>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php $box = Box::begin([
            'renderBody' => false,
            'collapsed' => true,
            'title' => Yii::t('hipanel:client', 'Additional information'),
        ]) ?>
        <?php $box->beginBody() ?>
        <fieldset id="fiz_domain">
            <div class="well well-sm"><?= Yii::t('hipanel:client', 'Physical entity information') ?></div>
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
        <hr>
        <fieldset id="jur_domain">
            <div class="well well-sm"><?= Yii::t('hipanel:client', 'Legal entity information') ?></div>
            <?= $form->field($model, 'organization_ru'); ?>
            <?= $form->field($model, 'director_name'); ?>
            <?= $form->field($model, 'inn'); ?>
            <?= $form->field($model, 'kpp'); ?>
            <?= $form->field($model, 'isresident')->checkbox(); ?>
        </fieldset>
        <hr>
        <fieldset id="tax_info">
            <div class="well well-sm"><?= Yii::t('hipanel:client', 'Registration data') ?></div>
            <?= $form->field($model, 'reg_data')->textArea() ?>
            <?= $form->field($model, 'vat_number') ?>
            <?= $form->field($model, 'vat_rate') ?>
            <?= $form->field($model, 'tax_comment') ?>
        </fieldset>
        <hr>
        <fieldset id="bank_info">
            <?= $form->field($model, 'bank_details')->textArea() ?>
        </fieldset>

        <?php $box->endBody() ?>
        <?php $box->end() ?>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->

<?php ActiveForm::end(); ?>
