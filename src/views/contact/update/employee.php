<?php

/**
 * @var \yii\web\View $this
 * @var string $scenario
 * @var array $countries
 * @var boolean $askPincode
 * @var \hipanel\modules\client\models\Contact $model
 * @var \yii\widgets\ActiveForm $form
 */

use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\widgets\BackButton;
use hipanel\widgets\Box;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

$i = 0;
$employeeForm = new \hipanel\modules\client\forms\EmployeeForm($model);
?>

<?= $this->render('_pincode', compact('askPincode')) ?>

<div class="row">
    <div class="col-md-12">
        <?php Box::begin(); ?>
        <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']); ?>
        <?= BackButton::widget() ?>
        <?php Box::end(); ?>
        <?= Html::activeHiddenInput($model, 'pincode', ['name' => 'pincode']); ?>
    </div>

    <?php foreach ($employeeForm->getContactLocalizations() as $language => $model) : ?>
        <div class="col-md-6">
            <?php Box::begin([
                'title' => Html::tag('span', $language, ['class' => 'label label-default']) . ' ' . Yii::t('hipanel:client', 'Contact details')
            ]) ?>
                <?php if ($model->scenario === 'update') : ?>
                    <?= $form->field($model, "[$i]id")->hiddenInput()->label(false); ?>
                <?php else: ?>
                    <?= $form->field($model, 'client_id')->widget(ClientCombo::class, [
                        'clientType' => 'employee'
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
                <?= $form->field($model, "[$i]voice_phone"); ?>
            <?php Box::end() ?>

            <?php Box::begin(['title' => Yii::t('hipanel:client', 'Bank details')]) ?>
            <fieldset id="bank_info">
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
<!-- /.row -->
