<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
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
            'value'  => function ($model) {
                return HTML::input('hidden', "ids[{$data->id}][Client][id]", $data->id, ['readonly' => 'readonly']) . HTML::tag('span', $data->login);
            },
        ],
        [
            'label'  => Yii::t('app', 'New login'),
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
