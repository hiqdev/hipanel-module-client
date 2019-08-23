<?php

/* @var $this yii\web\View */
/* @var $model hipanel\modules\client\models\Client */
/* @var $models hipanel\modules\client\models\Client[] */
/* @var $plans Plan[] */

/* @var $profiles TariffProfile[] */

use hipanel\helpers\ArrayHelper;
use hipanel\modules\finance\models\Plan;
use hipanel\modules\finance\models\TariffProfile;
use hipanel\widgets\ArraySpoiler;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$profilesWithPlans = [];
foreach ($profiles as $profile) {
    $profilesWithPlans[$profile->id] = ArrayHelper::csplit($profile->items['tariff']);
}
$this->registerJsVar('profilesWithPlans', $profilesWithPlans);

?>

<?php $form = ActiveForm::begin(['id' => 'assignments-form', 'action' => 'assign']) ?>

<?php foreach ($models as $model) : ?>
    <?= Html::activeHiddenInput($model, 'ids[]', ['value' => $model->id]) ?>
<?php endforeach ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-with-profiles">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel', 'Clients') ?></h3>
            </div>
            <div class="box-body">
                <?= ArraySpoiler::widget([
                    'data' => $models,
                    'visibleCount' => count($models),
                    'formatter' => function ($model) {
                        return $model->login;
                    },
                    'delimiter' => '&nbsp;',
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12">
        <div class="box box-with-profiles box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel', 'Profiles') ?></h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'profile_ids[]')->radioList(ArrayHelper::map($profiles, 'id', 'title')) ?>
            </div>
            <div class="overlay hidden"></div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="box box-with-plans">
            <div class="box-header with-border">
                <h3 class="box-title"><?= Yii::t('hipanel', 'Tariffs') ?></h3>
            </div>
            <div class="box-body">
                <?php foreach ($plans as $planType => $items) : ?>
                    <?php $planOptions = ArrayHelper::map($items, 'id', 'plan'); ?>
                    <?php if (in_array($planType, ['certificate', 'domain'])) : ?>
                        <?= $form->field($model, "tariff_ids[$planType][]")->radioList($planOptions)->label(strtoupper($planType)) ?>
                    <?php else : ?>
                        <?= $form->field($model, "tariff_ids[$planType][]")->checkboxList($planOptions)->label(strtoupper($planType)) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="overlay hidden"></div>
        </div>
    </div>
    <div class="col-lg-12">
        <?= Html::submitButton(Yii::t('hipanel', 'Assign'), ['class' => 'btn btn-success']) ?>
        &nbsp;
        <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
    </div>
</div>

<?php $form->end(); ?>

<?php $this->registerJs(/** @lang JavaScript */ "
$('#assignments-form .box').on('click', function () {
    $('#assignments-form').find('div.box').removeClass('box-success').find('.overlay').removeClass('hidden');
    $(this).addClass('box-success').find('.overlay').addClass('hidden');
    $('.box-with-plans :input').each(function () {
        this.disabled = false;
    });
});
$('#assignments-form .box.box-with-plans :input').on('change', function () {
    $('.box-with-profiles :radio').each(function () {
        this.checked = false;
    });
});
$('#assignments-form .box.box-with-profiles :radio').on('change', function () {
    var selectedPlans = profilesWithPlans[this.value];
    $('.box-with-plans :input').each(function () {
        this.disabled = true;
        if (selectedPlans.includes(this.value) && $(this).not(':checked')) {
            this.checked = true;
        } else {
            this.checked = false;
        }
    });
});
") ?>
