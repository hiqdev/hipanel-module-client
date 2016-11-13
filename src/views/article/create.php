<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

/* @var $this yii\web\View */
/* @var $model hipanel\modules\ticket\models\Ticket */

$this->title = Yii::t('hipanel:client', 'Create article');
$this->params['breadcrumbs'][] = ['label' => 'News and articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ticket-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
