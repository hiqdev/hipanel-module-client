<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\client\grid\ContactGridView;

$this->title                    = Yii::t('app', 'Contact');
$this->params['breadcrumbs'][]  = $this->title;
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

?>

<?= ContactGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'checkbox', 'seller_id', 'client_id',
        'name', 'email'
    ],
]); ?>

