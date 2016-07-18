<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

use hipanel\helpers\Url;
use hipanel\widgets\Box;
use hipanel\widgets\FileInput;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\ActiveForm;

/**
 * @var \hipanel\modules\client\models\Contact $model
 */

$this->title = Yii::t('hipanel/client', 'Attached documents');
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/client', 'Contacts'), 'url' => ['index']],
    ['label' => Inflector::titleize($model->name, true), 'url' => ['view', 'id' => $model->id]],
    $this->title,
]);

$form = ActiveForm::begin([
    'id' => 'attach-form',
    'action' => Url::to('attach-files'),
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
    'options' => ['enctype' => 'multipart/form-data'],
]) ?>

<div class="col-md-6 col-sm-12">

    <?php Box::begin([
        'title' => Yii::t('hipanel/client', 'Documents attached to the contact {name}', [
            'name' => Inflector::titleize($model->name, true)
        ])
    ]); ?>

    <p>
        <?= Yii::t('hipanel/client',
            'You can upload copy of your documents in order to help us verify your identity') ?>
    </p>

    <?php
    echo $form->field($model, 'id')->hiddenInput()->label(false);
    echo $form->field($model, 'file[]')->widget(FileInput::class, [
        'options' => [
            'multiple' => true,
        ],
        'pluginOptions' => [
            'previewFileType' => 'any',
            'showRemove' => true,
            'showUpload' => false,
            'initialPreviewShowDelete' => true,
            'maxFileCount' => 5,
            'msgFilesTooMany' => Yii::t('hipanel',
                'Number of files selected for upload ({n}) exceeds maximum allowed limit of {m}'),
        ],
    ])->label(false); ?>

    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
    <?= Html::submitButton(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'window.history.back();']); ?>

    <?php Box::end(); ?>

</div>


<?php

$form->end();

?>
