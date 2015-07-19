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
/* @var $model hipanel\modules\client\models\Article */

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => 'Article',
]);
$this->breadcrumbs->setItems([
    ['label' => 'News and articles', 'url' => ['index']],
    $this->title,
]);

?>
<div class="ticket-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
