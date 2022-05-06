<?php
declare(strict_types=1);

use hipanel\helpers\ArrayHelper;
use hipanel\modules\finance\models\Plan;
use hipanel\modules\finance\models\PlanType;
use hipanel\modules\finance\models\TariffProfile;
use hipanel\modules\finance\widgets\combo\PlanCombo;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\client\models\Client */
/* @var $models hipanel\modules\client\models\Client[] */
/* @var $planTypes PlanType[] */
/* @var $profiles TariffProfile[] */
/* @var $plansByType [] */

?>

    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="alert alert-warning difference-assignation hidden" role="alert">
                <strong><?= Yii::t('hipanel', 'Could not show currently selected profiles') ?></strong>
                <p><?= Yii::t('hipanel', 'One or more of the selected clients have different assignations') ?></p>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel', 'Clients') ?></h3>
                </div>
                <div class="box-body" style="columns: 4 auto">
                    <?php foreach (ArrayHelper::map($models, 'id', 'login') as $id => $login): ?>
                        <?= Html::a(
                            '<i class="fa fa-external-link fa-fw"></i> ' . Html::encode($login),
                            ['@client/view', 'id' => $id], ['target' => '_blank']
                        ) ?>
                        <br/>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php $form = ActiveForm::begin(['id' => 'assignments-form', 'action' => 'assign']) ?>

<?php foreach ($models as $model) : ?>
    <?= Html::activeHiddenInput($model, 'ids[]', ['value' => $model->id]) ?>
<?php endforeach ?>

    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="box box-with-profiles">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel', 'Profiles') ?></h3>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'profile_ids[]')->radioList(ArrayHelper::map($profiles, 'id', 'title')) ?>
                </div>
                <div class="overlay hidden"></div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="box box-with-plans">

                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('hipanel', 'Tariffs') ?></h3>
                </div>

                <?php foreach ($planTypes as $planType) : ?>
                    <div class="box-body">
                        <?php if (in_array($planType->name, [Plan::TYPE_CERTIFICATE, Plan::TYPE_DOMAIN], true)) : ?>
                            <?= $form
                                ->field($model, "tariff_ids[$planType->name][]")
                                ->widget(PlanCombo::class, ['hasId' => true, 'tariffType' => $planType->name, 'multiple' => false])
                                ->label(strtoupper($planType->label)) ?>
                        <?php else : ?>
                            <?= $form
                                ->field($model, "tariff_ids[$planType->name][]")
                                ->widget(PlanCombo::class, ['hasId' => true, 'tariffType' => $planType->name, 'multiple' => true, 'current' => []])
                                ->label(strtoupper($planType->label)) ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>

                <div class="overlay hidden"></div>
            </div>
        </div>
        <div class="col-lg-12">
            <?= Html::submitButton(Yii::t('hipanel', 'Assign'), ['class' => 'btn btn-success']) ?>
            &nbsp;
            <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>
        </div>
    </div>

<?php ActiveForm::end() ?>

<?php

$this->registerCss('.box .overlay, .overlay-wrapper .overlay { opacity: 0.6; }');

$profilesWithPlans = [];

foreach ($profiles as $profile) {
    $profilesWithPlans[$profile->id] = ArrayHelper::csplit($profile->items['tariff']);
}

$this->registerJsVar('profilesWithPlans', $profilesWithPlans);
$this->registerJs(/** @lang JavaScript */ "
(function () {
    function handleActiveBox() {
        $('#assignments-form').find('div.box').removeClass('box-success').find('.overlay').removeClass('hidden');
        $(this).addClass('box-success').find('.overlay').addClass('hidden');
        $('.box-with-plans :input').each(function () {
            this.disabled = false;
        });
    }
    function handleIfProfileSelected() {
        $('.box-with-profiles :radio').each(function () {
            this.checked = false;
        });
    }
    function handleIfPlanSelected() {
        const selectedPlans = profilesWithPlans[this.value];
        $('.box-with-plans :input').each(function () {
            this.disabled = true;
            if (selectedPlans.includes(this.value) && $(this).not(':checked')) {
                this.checked = true;
            } else {
                this.checked = false;
            }
        });
    }

    $('#assignments-form .box').on('click', handleActiveBox);
    $('#assignments-form .box.box-with-plans :input').on('change', handleIfProfileSelected);
    $('#assignments-form .box.box-with-profiles :radio').on('change', handleIfPlanSelected);
})();
");

$allTheSame = true;
$profiles = [];
$plans = [];

foreach ($models as $client) {
    $profiles = array_merge($profiles, $client->tariffAssignment->profileIds);
    $plans = array_merge($plans, $client->tariffAssignment->planIds);
    if (array_diff($profiles, $client->tariffAssignment->profileIds) || array_diff($plans, $client->tariffAssignment->planIds)) {
        $allTheSame = false;
        break;
    }
}

if ($allTheSame) {
    $this->registerJsVar('currentProfiles', $model->tariffAssignment->profileIds);
    $this->registerJsVar('currentPlans', $model->tariffAssignment->planIds);
    $this->registerJsVar('plansByType', $plansByType);
    $this->registerJs(/** @lang JavaScript */ "
        (function () {
            if (currentProfiles.length) {
              $('.box-with-profiles').click();
              $('.box-with-profiles :radio').val(currentProfiles).change();
            } else if (currentPlans.length) {
              $('.box-with-plans').click();
              Object.entries(plansByType).forEach(entry => {
                const [type, plans] = entry;
                Object.entries(plans).forEach(entry => {
                  const [planId, planName] = entry;
                  if (currentPlans.includes(planId)) {
                    const newOption = new Option(planName, planId, true, true);
                    $(`:input[id*=\"-\${type}\"]`).append(newOption).trigger('change select2:select')
                  }
                });
              });
            }
        })();
    ");
} else {
    $this->registerJs("$('.difference-assignation').removeClass('hidden');");
}
