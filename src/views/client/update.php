<?php

use hipanel\modules\client\models\Client;

/**
 * @var Client $model
 * @var Client[] $models
 * @var array $currencies
 */


$this->title = Yii::t('hipanel', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Client'), 'url' => ['index']];
if (count($models) === 1) {
    $this->params['breadcrumbs'][] = ['label' => $model->login, 'url' => ['@client/view', 'id' => $model->id]];
}
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', ['model' => $model, 'models' => $models, 'currencies' => $currencies]) ?>

