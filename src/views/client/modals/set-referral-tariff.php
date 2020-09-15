<?php

use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hipanel\modules\finance\widgets\combo\PlanCombo;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var Client $client */

?>

<?php $form = ActiveForm::begin([
    'id' => 'mon-form',
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $client->scenario]),
]); ?>

<?= Html::activeHiddenInput($client, 'id') ?>

<?= $form->field($client, 'tariff_ids[]')->widget(PlanCombo::class, ['tariffType' => 'referral', 'hasId' => true]) ?>

<?= Html::submitButton(Yii::t('hipanel:client', 'Set tariff plan'), ['class' => 'btn btn-success btn-block']) ?>

<?php $form::end() ?>
