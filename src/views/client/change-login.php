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
use yii\widgets\Pjax;

$this->title = 'Set credit';
$this->breadcrumbs->setItems([
    $this->title,
]);

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
            'value'  => function ($model) {
                return HTML::input('hidden', "ids[{$data->id}][Client][id]", $data->id, ['readonly' => 'readonly']) . HTML::tag('span', $data->login);
            },
        ],
        [
            'label'  => Yii::t('hipanel/client', 'New login'),
            'format' => 'raw',
            'value'  => function ($data) {
                return Html::input('text', "ids[$data->id}][Client][language]", $data->login);
            },
        ],
    ],
];
echo GridView::widget($widgetIndexConfig);

Pjax::end();

echo Html::endForm();
