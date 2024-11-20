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
use hipanel\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$currencies = $this->context->getCurrencyTypes();
$purses = array_map(function ($k) {
    return $k->currency;
}, $model->purses);

$currencies = array_filter(
    array_combine(array_keys($currencies), array_map(function ($k) {
        return StringHelper::getCurrencySymbol($k);
    }, array_keys($currencies))), function ($k) use ($purses) {
        return in_array($k, $purses, true);
    }, ARRAY_FILTER_USE_KEY
);

/// Allowed euro by default
$currencies['eur'] = '€';

?>

<?php $form = ActiveForm::begin([
    'options' => [
        'id' => 'finance-settings-form',
    ],
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

    <?= $form->field($model, 'finance_emails')->textInput(['placeholder' => 'finance@acme.org, ceo@acme.org']) ?>

    <?= $form->field($model, 'autoexchange_to')->dropDownList($currencies)?>

    <?= $form->field($model, 'autoexchange_enabled')->checkbox() ?>

    <?= $form->field($model, 'autoexchange_prepayments')->checkbox() ?>

    <?php if (Yii::$app->user->can('bill.create-exchange')) : ?>
        <?= $form->field($model, 'autoexchange_force')->checkbox() ?>
    <?php endif ?>

    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
