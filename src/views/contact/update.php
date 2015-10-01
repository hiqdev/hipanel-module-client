<?php

$this->title                   = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contact'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if (!$models) $models[] = $model;

foreach ($models as $model) {
    $model->scenario = $scenario;
    echo $this->render('_form', ['model' => $model, 'countries' => $countries, 'askPincode' => $askPincode ]);
}

