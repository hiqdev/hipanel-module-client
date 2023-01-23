<?php

use hipanel\modules\client\forms\EmployeeForm;
use borales\extensions\phoneInput\PhoneInput;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\BackButton;
use hipanel\widgets\Box;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * @var \yii\web\View
 * @var array $countries
 * @var Contact $model the primary model
 * @var ActiveForm $form
 * @var EmployeeForm $employeeForm
 */

$i = 0;
$contract = $employeeForm->getContract();
?>

<div class="row">
    <div class="col-md-12">
        <?php Box::begin(); ?>
            <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
            <?= BackButton::widget() ?>
        <?php Box::end(); ?>
        <?= Html::hiddenInput('pincode', null, ['id' => 'contact-pincode']) ?>
    </div>

    <?php foreach ($employeeForm->getContacts() as $language => $model) : ?>
        <div class="col-md-6">
            <?php Box::begin([
                'title' => Html::tag('span', $language, ['class' => 'label label-default']) . ' ' . Yii::t('hipanel:client', 'Contact details'),
            ]) ?>
                <?php if ($model->scenario === 'update') : ?>
                    <?= Html::activeHiddenInput($model, "[$i]id") ?>
                    <?= Html::activeHiddenInput($model, "[$i]localization") ?>
                <?php else: ?>
                    <?= $form->field($model, 'client_id')->widget(ClientCombo::class, [
                        'clientType' => 'employee',
                    ]); ?>
                <?php endif; ?>
                <?= $form->field($model, "[$i]first_name"); ?>
                <?= $form->field($model, "[$i]last_name"); ?>
                <?= $form->field($model, "[$i]email"); ?>
                <?= $form->field($model, "[$i]street1"); ?>
                <?= $form->field($model, "[$i]street2"); ?>
                <?= $form->field($model, "[$i]street3"); ?>
                <?= $form->field($model, "[$i]city"); ?>
                <?= $form->field($model, "[$i]country")->widget(StaticCombo::class, [
                    'inputOptions' => ['id' => 'country-' . $language . '-' . $model->client_id],
                    'data' => $countries,
                    'hasId' => true,
                ]); ?>
                <?= $form->field($model, "[$i]province"); ?>
                <?= $form->field($model, "[$i]postal_code"); ?>
                <?= $form->field($model, "[$i]voice_phone")->widget(PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => array_values(array_unique(array_filter([$model->country, 'ua','us', 'gb', 'nl']))),
                        'initialCountry' => 'auto',
                    ],
                ]) ?>
            <?php Box::end() ?>

            <?php Box::begin(['title' => Yii::t('hipanel:client', 'Bank details')]) ?>
            <fieldset id="bank_info">
                <?= $form->field($model, "[$i]vat_number") ?>
                <?= $form->field($model, "[$i]bank_account") ?>
                <?= $form->field($model, "[$i]bank_name") ?>
                <?= $form->field($model, "[$i]bank_address") ?>
                <?= $form->field($model, "[$i]bank_swift") ?>
            </fieldset>
            <?php Box::end() ?>
        </div>
    <?php $i++ ?>
    <?php endforeach; ?>
</div>
<?php if ($contract) : ?>
    <div class="row">
        <div class="col-md-6">
            <?php $box = Box::begin(['renderBody' => false]) ?>
                <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Yii::t('hipanel:client', 'Contract information')) ?>
                <?php $box::endHeader() ?>
                <?php $box->beginBody() ?>

                    <?= Html::activeHiddenInput($contract, 'sender_id', ['value' => $model->seller_id]) ?>
                    <?= Html::activeHiddenInput($contract, 'receiver_id', ['value' => $model->client_id]) ?>

                    <?php
                        foreach ($employeeForm->getContractFields() as $name => $label) {
                            if ($name === 'date') {
                                $form->field($contract, "data[date]")->widget(MaskedInput::class, [
                                        'mask' => '99.99.9999',
                                    ])->label($label);
                            }
                            echo $form->field($contract, "data[$name]")->label($label);
                        }
                    ?>
                <?php $box->endBody() ?>
            <?php $box::end(); ?>
        </div>
    </div>
<?php endif; ?>
