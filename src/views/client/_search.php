<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\DatePicker;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

/**
 * @var \hipanel\widgets\AdvancedSearch
 */
?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('login_like') ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('note_like') ?>
    </div>
<?php endif ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('email_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_like') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_id')->widget(ClientCombo::class) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('types')->widget(StaticCombo::class, [
        'data'      => $types,
        'hasId'     => true,
        'multiple'  => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('states')->widget(StaticCombo::class, [
        'data'      => $states,
        'hasId'     => true,
        'multiple'  => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= Html::tag('label', Yii::t('hipanel/client', 'Registered range'), ['class' => 'control-label']); ?>
        <?= DatePicker::widget([
            'model'         => $search->model,
            'type'          => DatePicker::TYPE_RANGE,
            'attribute'     => 'create_time_ge',
            'attribute2'    => 'create_time_lt',
            'pluginOptions' => [
                'autoclose' => true,
                'format'    => 'yyyy-mm-dd',
            ],
        ]) ?>
    </div>
</div>
