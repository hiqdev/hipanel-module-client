<?php

use hipanel\modules\client\models\Client;

/**
 * @var Client $model
 * @var Client[] $models
 * @var array $currencies
 */

$this->title = Yii::t('hipanel:client', 'Create client');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Client'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', ['model' => $model, 'models' => $models, 'currencies' => $currencies]) ?>
