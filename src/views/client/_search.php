<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\client\widgets\combo\RefererCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hipanel\widgets\AdvancedSearch;
use hiqdev\combo\StaticCombo;
use hiqdev\yii2\daterangepicker\DateRangePicker;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var AdvancedSearch $search
 * @var IndexPageUiOptions $uiModel
 * @var array $types
 * @var array $states
 * @var View $this
 */

?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('login_email_like') ?>
</div>

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('note_ilike') ?>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('custom_attributes') ?>
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

<?php if (Yii::$app->user->can('support')) : ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('referer_id')->widget(RefererCombo::class) ?>
    </div>
<?php endif ?>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('types')->widget(StaticCombo::class, [
        'data' => $types,
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <?= $search->field('states')->widget(StaticCombo::class, [
        'data' => $states,
        'hasId' => true,
        'multiple' => true,
    ]) ?>
</div>

<?php if ($uiModel->representation === 'profit-report'): ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <?= $search->field('profit_not_empty')->checkbox() ?>
    </div>
<?php endif; ?>

<div class="row top-buffer"></div>

<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="form-group">
        <?= Html::tag('label', Yii::t('hipanel:client', 'Registered range'), ['class' => 'control-label']); ?>
        <?= DateRangePicker::widget([
            'model' => $search->model,
            'attribute' => 'create_date_ge',
            'attribute2' => 'create_date_le',
            'options' => [
                'class' => 'form-control',
            ],
            'dateFormat' => 'yyyy-MM-dd',
        ]) ?>
    </div>
</div>

<?php if ($uiModel->representation === 'profit-report'): ?>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="form-group">
            <?= Html::tag('label', Yii::t('hipanel:client', 'Profit period'), ['class' => 'control-label']); ?>
            <?= DateRangePicker::widget([
                'model' => $search->model,
                'attribute' => 'profit_time_from',
                'attribute2' => 'profit_time_till',
                'options' => [
                    'class' => 'form-control',
                ],
                'dateFormat' => 'yyyy-mm-dd',
            ]) ?>
        </div>
    </div>
<?php endif ?>
