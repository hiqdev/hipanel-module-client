<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

use hipanel\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Set seller';
$this->breadcrumbs->setItems([
    ['label' => 'Client', 'url' => ['index']],
    $this->title,
]);

echo Html::beginForm(['set-credit'], 'POST');

if (!Yii::$app->request->isAjax) {
    echo Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']);
}
if (!Yii::$app->request->isAjax) {
    echo Html::submitButton(Yii::t('app', 'Cancel'), ['type' => 'cancel', 'class' => 'btn btn-success', 'onClick' => 'history.back()']);
}
Pjax::begin();

$widgetIndexConfig = [
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'label'  => Yii::t('app', 'Client'),
            'format' => 'raw',
            'value'  => function ($data) {
                return HTML::input('hidden', "ids[{$data->id}][Client][id]", $data->id, ['readonly' => 'readonly']) . HTML::tag('span', $data->login);
            },
        ],
        [
            'label'  => Yii::t('app', 'Seller'),
            'format' => 'raw',
            'value'  => function ($data) {
                return Html::dropDownList("ids[$data->id}][Client][seller_id]", $data->seller_id);
            },
        ],
    ],
];
echo GridView::widget($widgetIndexConfig);

Pjax::end();

echo Html::endForm();
