<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\grid\GridView;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title = 'Set credit';
$this->params['breadcrumbs'][] = ['label' => 'Client', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginForm(['set-credit'], 'POST');

if (!Yii::$app->request->isAjax) {
    echo Html::submitButton(Yii::t('hipanel', 'Submit'), ['class' => 'btn btn-primary']);
}
if (!Yii::$app->request->isAjax) {
    echo Html::submitButton(Yii::t('hipanel', 'Cancel'), ['type' => 'cancel', 'class' => 'btn btn-success', 'onClick' => 'history.back()']);
}

Pjax::begin();

$widgetIndexConfig = [
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'label'  => Yii::t('hipanel', 'Client'),
            'format' => 'raw',
            'value'  => function ($data) {
                return HTML::input('hidden', "ids[{$data->id}][Client][id]", $data->id, ['readonly' => 'readonly', 'disabled' => $data->id === \Yii::$app->user->identity->id || \Yii::$app->user->identity->type === 'client' || \Yii::$app->user->identity->type === 'admin']) . HTML::tag('span', $data->login);
            },
        ],
        [
            'label'  => Yii::t('hipanel', 'Credit'),
            'format' => 'raw',
            'value'  => function ($data) {
                return HTML::input('number', "ids[{$data->id}][Client][credit]", $data->credit, ['min' => 0, 'step' => 0.01, 'disabled' => $data->id === \Yii::$app->user->identity->id || \Yii::$app->user->identity->type === 'client' || \Yii::$app->user->identity->type === 'admin']);
            },
        ],
    ],
];
echo GridView::widget($widgetIndexConfig);

Pjax::end();

echo Html::endForm();
