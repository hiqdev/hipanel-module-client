<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

$this->title                   = Yii::t('hipanel/client', 'Create contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Contact'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if (!$models && $model) {
    $models[] = $model;
}
foreach ($models as $model) {
    $model->scenario = $scenario;
    echo $this->render('_form', ['model' => $model, 'countries' => $countries]);
}
