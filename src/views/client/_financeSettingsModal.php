<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

/**
 * @var \hipanel\modules\client\models\Client
 * @var \yii\base\View
 */

use hipanel\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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

    <?php if (count($model->purses) > 1) : ?>
        <?php
        $currencies = $this->context->getCurrencyTypes();
        $purses = array_map(function ($k) {
            return $k->currency;
        }, $model->purses);

        $currencies = array_filter(
            array_combine(array_keys($currencies), array_map(function ($k) {
                return StringHelper::getCurrencySymbol($k);
            }, array_keys($currencies))), function ($k) use ($purses) {
            return in_array($k, $purses, true);
        }, ARRAY_FILTER_USE_KEY);
        ?>

        <?= $form->field($model, 'autoexchange_to')->dropDownList($currencies)->hint(Yii::t('hipanel:client', 'Select the preferred currency for invoicer')) ?>

        <?= $form->field($model, 'autoexchange_enabled')->checkbox()->hint(Yii::t('hipanel:client', 'When the primary currency (say EUR) balance is positive and the secondary currency (say USD) has debts, exchange as much available EUR as possible to close USD debts')) ?>

        <?php if (Yii::$app->user->can('manage')) : ?>
            <?= $form->field($model, 'autoexchange_force')->checkbox()->hint(Yii::t('hipanel:client', 'When "exchange currency for debts automatically" is enabled, this flag indicates that the primary currency CAN be indebted to close debts in other currencies')) ?>
        <?php endif ?>
    <?php endif ?>
    <hr>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?> &nbsp;
    <?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>
