<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\modules\client\models\Client;

/**
 * @var Client $model
 */

$this->title = $model->login;
$this->params['subtitle'] = sprintf('%s %s', Yii::t('hipanel:client', 'Client detailed information'), (Yii::$app->user->can('support') ? ' #' . $model->id : ''));
if (Yii::$app->user->can('client.read')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Clients'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;

if ($model->type === Client::TYPE_EMPLOYEE) {
    echo $this->render('view/employee', ['model' => $model]);
} else {
    echo $this->render('view/client', ['model' => $model]);
}
