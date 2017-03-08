<?php

/**
 * @var \yii\web\View $this
 * @var string $scenario
 * @var array $countries
 * @var boolean $askPincode
 * @var \hipanel\modules\client\models\Contact $model
 * @var \yii\bootstrap\ActiveForm $form
 */

?>

<?= $this->render('_pincode', compact('askPincode')) ?>

<?= $this->render('../_form', compact('model', 'countries', 'model', 'form')) ?>
