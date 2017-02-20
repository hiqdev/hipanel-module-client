<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

use yii\helpers\Inflector;

if (!$models) {
    $models[] = $model;
}

$this->title = Yii::t('hipanel', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:client', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Inflector::titleize(reset($models)->getName(), true), 'url' => ['view', 'id' => reset($models)->id]];
$this->params['breadcrumbs'][] = $this->title;

foreach ($models as $model) {
    $model->scenario = $scenario;
    echo $this->render('_form', ['model' => $model, 'countries' => $countries, 'askPincode' => $askPincode]);
}
