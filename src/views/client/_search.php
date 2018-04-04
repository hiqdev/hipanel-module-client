<?php

use hipanel\modules\client\widgets\combo\SellerCombo;
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
        <?= $search->field('note_ilike') ?>
    </div>
<?php endif ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('name_ilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('email_ilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_ilike') ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('seller_id')->widget(SellerCombo::class) ?>
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

<?php if ($uiModel->representation === 'payment') : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('sold_services')->widget(StaticCombo::class, [
            'data'      => $sold_services,
            'hasId'     => true,
            'multiple'  => true,
        ]) ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('debt_gt') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('debt_lt') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('debt_depth_gt') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('debt_depth_lt') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('hide_vip')->checkbox() ?>
    </div>


<?php endif ?>

<div class="row top-buffer"></div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= Html::tag('label', Yii::t('hipanel:client', 'Registered range'), ['class' => 'control-label']); ?>
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

<?php if ($uiModel->representation === 'payment') : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <?= Html::tag('label', Yii::t('hipanel:client', 'Financial month'), ['class' => 'control-label']); ?>
            <?= DatePicker::widget([
                'model'         => $search->model,
                'type'          => DatePicker::TYPE_INPUT,
                'attribute'     => 'financial_month',
                'pluginOptions' => [
                    'autoclose' => true,
                    'startView' => 'year',
                    'minViewMode' => 'months',
                    'format'    => 'yyyy-mm-01',
                ],
            ]) ?>
        </div>
    </div>
<?php endif ?>
