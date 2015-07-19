<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\modules\client\grid\ClientGridView;

$this->title    = Yii::t('app', 'Clients');
$this->subtitle = Yii::$app->request->queryParams ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);

?>

<?= ClientGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox',
        'id', 'seller_id',
        'email', 'name',
        'type', 'state',
        'balance', 'credit',
        'create_time',
        'action',
    ],
]) ?>
