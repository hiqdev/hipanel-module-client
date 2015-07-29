<?php
use hipanel\widgets\Box;
use hiqdev\combo\StaticCombo;
use kartik\widgets\DatePicker;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

$this->registerCss('legend { font-size: 15px; }');
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
    <?php $this->registerJs(<<<JS
    jQuery('#contact-form').on('beforeSubmit', function(event, attributes, messages, deferreds) {
        event.preventDefault();
        var show = true;
        for (var attr in attributes) {
            if (attributes[attr].length == 0) {
                show = false;
                return;
            }
        }
        if (show) {
            jQuery('#askpincode-modal').modal('show');
        }
        return false;
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
        'header' => '<h4 class="modal-title">' . Yii::t('app', 'Enter pincode') . '</h4>',
        'clientEvents' => [
            'show.bs.modal' => new JsExpression("function() {document.getElementById('modal-pincode').value = '';}")
        ],
        'footer' => Html::submitButton(Yii::t('app', 'Submit'), [
            'id' => 'modal-ask-pincode-button',
            'class' => 'btn btn-default btn-loading',
            'data-loading-text' => Yii::t('app', 'Loading') . '...',
            'data-loading-icon' => 'glyphicon glyphicon-refresh',
        ]),
    ]); ?>
        <?= Html::textInput('modal-pincode', null, ['id' => 'modal-pincode', 'class' => 'form-control', 'placeholder' => Yii::t('app', 'Type pincode here...')]); ?>
    <?php Modal::end(); ?>
<?php endif; ?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'action' => $this->context->action->id == 'copy' ? Url::toRoute('create') : '',
    'enableClientValidation' => true,
    'validateOnBlur'         => true,
    'enableAjaxValidation'   => true,
    'layout'                 => 'horizontal',
    'validationUrl'          => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>
<?php if ($askPincode['pincode_enabled']) : ?>

<?php endif; ?>
<div class="row">
    <?= Html::activeHiddenInput($model, 'pincode'); ?>

    <div class="col-md-12">
        <?php Box::begin(); ?>
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']); ?>
        <?php Box::end(); ?>
    </div>
    <!-- /.com-md-12 -->

    <div class="col-md-6">
        <?php Box::begin(['title' => Yii::t('app', 'Contacts details')]) ?>
        <?= $form->field($model, 'first_name'); ?>
        <?= $form->field($model, 'last_name'); ?>
        <?= $form->field($model, 'email'); ?>
        <?= $form->field($model, 'abuse_email'); ?>
        <?= $form->field($model, 'organization'); ?>
        <?= $form->field($model, 'street1'); ?>
        <?= $form->field($model, 'street2'); ?>
        <?= $form->field($model, 'street3'); ?>
        <?= $form->field($model, 'city'); ?>
        <?= $form->field($model, 'country')->widget(StaticCombo::classname(), [
            'data'  => $countries,
            'hasId' => true,
        ]); ?>
        <?= $form->field($model, 'province'); ?>
        <?= $form->field($model, 'postal_code'); ?>
        <?= $form->field($model, 'voice_phone'); ?>
        <?= $form->field($model, 'fax_phone'); ?>

        <?php Box::end() ?>
    </div>
    <!-- /.col-md-6 -->
    <div class="col-md-6">
        <?php Box::begin(['title' => Yii::t('app', 'Additional contacts information')]) ?>
        <?= $form->field($model, 'icq'); ?>
        <?= $form->field($model, 'skype'); ?>
        <?= $form->field($model, 'jabber'); ?>
        <?= $form->field($model, 'other_messenger'); ?>
        <?php Box::end() ?>
    </div>
    <!-- /.col-md-6 -->
    <div class="col-md-6">
        <?php $box = Box::begin(['renderBody' => false, 'options' => [
            'class'                           => 'collapsed-box',
        ]]) ?>
        <?php $box->beginHeader(); ?>
        <h3 class="box-title"><?= Yii::t('app', 'Additional fields') ?></h3>

        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
        <!-- /.box-tools -->
        <?php $box->endHeader(); ?>
        <?php $box->beginBody() ?>
        <fieldset id="fiz_domain">
            <legend><?= Yii::t('app', 'Для регистрации доменов в зоне RU в качестве физического лица') ?></legend>
            <?= $form->field($model, 'birth_date')->widget(DatePicker::className(), [
                'removeButton'  => false,
                'pluginOptions' => [
                    'format'    => 'dd.mm.yyyy',
                    'autoclose' => true,
                    'clearBtn'  => true,
                ],
                'options' => ['readonly' => 'readonly', 'class' => 'datepicker'],
            ]); ?>
            <?= $form->field($model, 'passport_no'); ?>
            <?= $form->field($model, 'passport_date')->widget(DatePicker::className(), [
                'removeButton'  => false,
                'pluginOptions' => [
                    'format'    => 'dd.mm.yyyy',
                    'autoclose' => true,
                    'clearBtn'  => true,
                ],
                'options' => ['readonly' => 'readonly', 'class' => 'datepicker'],
            ]);  ?>
            <?= $form->field($model, 'passport_by'); ?>
        </fieldset>
        <fieldset id="jur_domain">
            <legend><?= Yii::t('app', 'Для регистрации доменов в зоне RU в качестве юридического лица') ?></legend>
            <?= $form->field($model, 'organization_ru'); ?>
            <?= $form->field($model, 'director_name'); ?>
            <?= $form->field($model, 'inn'); ?>
            <?= $form->field($model, 'kpp'); ?>
            <?= $form->field($model, 'isresident')->checkbox(); ?>
        </fieldset>
        <?php $box->endBody() ?>
        <?php $box::end() ?>
    </div>
    <!-- /.col-md-6 -->
</div>
<!-- /.row -->

<?php ActiveForm::end(); ?>
