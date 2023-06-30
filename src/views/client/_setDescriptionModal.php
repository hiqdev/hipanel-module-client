<?php
/**
 * Client module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

/**
 * @var \hipanel\modules\client\models\Client $model
 * @var \yii\base\View $this
 */

use dosamigos\tinymce\TinyMce;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$this->registerJs(<<<"JS"
    $("#{$model->id}_description_modal_form").on('hidden.bs.modal', function (e) {
      window.location.reload();
    });
JS
);

$form = ActiveForm::begin([
    'options' => [
        'id' => 'client-description-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= Html::activeHiddenInput($model, "[$model->id]id") ?>

    <?= $form->field($model, "[$model->id]description")->widget(TinyMce::class, [
        'name' => 'content',
        'value' => $model->description,
        'options' => ['rows' => 6],
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ],
    ])->label(false) ?>

    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
