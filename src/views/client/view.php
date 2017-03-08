<?php

/**
 * @var \yii\web\View $this
 * @var \hipanel\modules\client\models\Client $client
 */

use hipanel\modules\client\models\Client;

$this->title = $model->login;
$this->params['subtitle'] = Yii::t('hipanel:client', 'Client detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if ($model->type === Client::TYPE_EMPLOYEE) {
    echo $this->render('view/employee', compact('model'));
} else {
    echo $this->render('view/client', compact('model'));
}
