<?php declare(strict_types=1);

use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use hipanel\modules\client\models\Blacklist;
use hipanel\widgets\Box;
use hiqdev\combo\StaticCombo;
use yii\bootstrap\ActiveForm;

/**
 * @var Blacklist $model
 * @var ActiveForm $form
 * @var array $types
 * @var BlacklistCategoryInterface $blacklistCategory
 */

$isCreateScenario = $model->scenario === 'create';
?>

<div class="row">

    <div class="col-md-6">
        <?php Box::begin(['title' => Yii::t('hipanel:client', $blacklistCategory->getLabel() . ' details')]) ?>
        <?php if (!$isCreateScenario) : ?>
            <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <?php else: ?>
            <?= $form->field($model, 'category')->hiddenInput(['value' => $blacklistCategory->getExternalValue()])->label(false) ?>
        <?php endif; ?>

        <?= $form->field($model, 'name') ?>

        <?php if ($types) : ?>
            <?= $form->field($model, 'type')->widget(StaticCombo::class, [
                'data' => $types,
                //'hasId' => true,
            ]) ?>
        <?php endif; ?>

        <?= $form->field($model, 'message') ?>
        <?= $form->field($model, 'show_message')->checkbox() ?>

        <?php Box::end() ?>
    </div>
</div>
