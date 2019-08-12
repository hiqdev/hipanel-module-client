<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

/**
 * @var \yii\web\View $this
 * @var \hipanel\modules\client\models\Client $model
 */

$this->title = $model->login;
$this->params['subtitle'] = sprintf('%s %s', Yii::t('hipanel:client', 'Assignments detailed information'), (Yii::$app->user->can('support') ? ' #' . $model->id : ''));
if (Yii::$app->user->can('client.read')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Clients'), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;

