<?php

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\finance\widgets\ResourceListViewer;
use hiqdev\hiart\ActiveDataProvider;
use yii\db\ActiveRecordInterface;

/** @var ActiveRecordInterface $originalModel */
/** @var ActiveRecordInterface $model */
/** @var ActiveDataProvider $dataProvider */
/** @var IndexPageUiOptions $uiModel */

$this->title = Yii::t('hipanel', 'Client resources');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:client', 'Clients'), 'url' => ['@client/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= ResourceListViewer::widget([
    'dataProvider' => $dataProvider,
    'originalContext' => $this->context,
    'originalSearchModel' => $model,
    'uiModel' => $uiModel,
    'configurator' => Yii::$container->get('client-referral-resource-configuration'),
]) ?>
