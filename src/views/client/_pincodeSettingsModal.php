<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'id' => $model->scenario . '-form',
    ],
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]); ?>
<?= Html::activeHiddenInput($model, "[$model->id]id"); ?>
<?= Html::activeHiddenInput($model, "[$model->id]pincode_enabled"); ?>
<?php if ($model->pincode_enabled) : ?>
    <?php
    $this->registerJs(<<<JS
    jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        jQuery('#' + e.relatedTarget.getAttribute('href').substr(1)).find('input:text').val(''); //e.target
    });
JS
    );
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <?= Tabs::widget([
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Disable pincode'),
                            'content' => $form->field($model, "[$model->id]pincode"),
                            'active' => true
                        ],
                        [
                            'label' => Yii::t('app', 'Forgot pincode?'),
                            'content' => $form->field($model, "[$model->id]answer")->label($model->question),
                        ],
                    ],
                ]); ?>
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col-md-12 -->
    </div>
<?php else : ?>
    <?php
    $this->registerJs(<<<JS
    jQuery( document ).on( "change", "select.client-question", function() {
        var selectField = jQuery(this), textField = jQuery('input.own-question');
        if (this.value == 'own') {
            textField.attr('disabled', false).show();
        } else {
            textField.attr('disabled', true).hide();
        }
    });
JS
    );
    ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, "[$model->id]pincode")->textInput(['value' => mt_rand(1000, 9999)]) ?>
            <?= $form->field($model, "[$model->id]question")->dropDownList($questionList, ['class' => 'client-question form-control']) ?>
            <?= Html::activeTextInput($model, "[$model->id]question", [
                'class' => 'own-question form-control',
                'style' => 'display: none;',
                'value' => '',
                'disabled' => true,
                'placeholder' => Yii::t('app', 'Enter your question'),
            ]) ?>
            <?= $form->field($model, "[$model->id]answer") ?>
        </div>
        <!-- /.col-md-12 -->
    </div>
<?php endif; ?>
<!-- /.row -->
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-default']) ?>
<?php $form::end(); ?>
