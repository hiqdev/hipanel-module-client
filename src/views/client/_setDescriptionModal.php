<?php
/**
 * Client module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

/**
 * @var Client $model
 * @var View $this
 */

use hipanel\modules\client\models\Client;
use hipanel\widgets\TrumbowygInput;
use yii\web\View;
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

    <?= $form->field($model, "[$model->id]description")->widget(TrumbowygInput::class, [
        'name' => 'content',
        'value' => $model->description,
    ])->label(false) ?>

    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
