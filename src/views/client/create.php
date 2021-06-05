<?php

$this->title = Yii::t('hipanel:client', 'Create client');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Client'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('model', 'models', 'currencies')) ?>
