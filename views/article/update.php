<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\client\models\Article */

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => 'Article',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'News and articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-create">
    <?= $this->render('_form', ['model' => $model]); ?>
</div>
