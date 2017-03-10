<?php

use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\web\View;

/**
 * @var View $this
 * @var array $askPincode
 */

$askPincode = (bool)$askPincode['pincode_enabled'];
$isClient = (bool)Yii::$app->user->can('role:client');
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

<?php $this->registerJs(<<<"JS"
    var oldEmail = document.getElementById('contact-oldemail');
    var show = false, askPincode = Boolean('{$askPincode}'), isClient =  Boolean('{$isClient}');
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
            if (attribute.name === 'Contact[email]' && oldEmail) {
                if (attribute.value !== oldEmail.value && (askPincode && isClient) ) {
                    show = true;
                }
            }
        }
        if (show || !isClient) {
            debugger;
            event.preventDefault();
            jQuery('#askpincode-modal').modal('show');
            return false;
        }
    });
    jQuery('#modal-ask-pincode-button').on('click', function(e) {
        var pincode = jQuery('#modal-pincode').val();
        jQuery('#contact-pincode').val(pincode);
        document.getElementById("contact-form").submit();
    });
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
<?= Html::textInput('modal-pincode', null, [
    'id' => 'modal-pincode',
    'class' => 'form-control',
    'placeholder' => Yii::t('hipanel:client', 'Type pincode here...'),
]); ?>
<?php Modal::end(); ?>
