<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use hipanel\modules\client\grid\ClientGridView;

$this->title                    = Yii::t('app', 'Clients');
$this->params['breadcrumbs'][]  = $this->title;
$this->params['subtitle']       = Yii::$app->request->queryParams ? 'filtered list' : 'full list';

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
    ],
]) ?>
