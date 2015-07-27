<?php

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Name Server'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form', ['model' => $model, 'countries' => $countries, 'askPincode' => $askPincode]); ?>

