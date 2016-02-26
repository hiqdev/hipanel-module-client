<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\combo\StaticCombo;
use kartik\widgets\DatePicker;
use yii\helpers\Html;

?>

<div class="col-md-4">
    <?= $search->field('client_like') ?>
    <?= $search->field('name_like')->label(Yii::t('app', 'Name')) ?>
</div>

<div class="col-md-4">
    <?= $search->field('seller_like') ?>
    <?= $search->field('seller_id')->widget(ClientCombo::classname()) ?>
</div>

<div class="col-md-4">
    <?= $search->field('state')->widget(StaticCombo::classname(), [
        'data'          => $states,
        'hasId'         => true,
        'pluginOptions' => [
            'select2Options' => [
                'multiple' => true,
            ],
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::tag('label', 'Registered range', ['class' => 'control-label']); ?>
        <?= DatePicker::widget([
            'model'         => $search->model,
            'type'          => DatePicker::TYPE_RANGE,
            'attribute'     => 'created_from',
            'attribute2'    => 'created_till',
            'pluginOptions' => [
                'autoclose' => true,
                'format'    => 'yyyy-mm-dd',
            ],
        ]) ?>
    </div>
</div>
