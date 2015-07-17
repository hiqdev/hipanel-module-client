<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\client\grid\ContactGridView;

$this->title    = Yii::t('app', 'Contact');
$this->subtitle = Yii::$app->request->queryParams ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);

?>

<?= ContactGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox', 'seller_id', 'client_id',
        'name', 'email'
    ],
]); ?>

