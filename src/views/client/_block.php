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
use hipanel\models\Ref;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('hipanel', ucfirst($action)) . ' ' . Yii::t('hipanel', 'block');
$this->params['breadcrumbs'][] = ['label' => 'Client', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::beginForm([$action . '-block'], 'POST');

if (!Yii::$app->request->isAjax) {
    echo Html::submitButton(Yii::t('hipanel', 'Submit'), ['class' => 'btn btn-primary']);
}
if (!Yii::$app->request->isAjax) {
    echo Html::submitButton(Yii::t('hipanel', 'Cancel'), ['type' => 'cancel', 'class' => 'btn btn-success', 'onClick' => 'history.back()']);
}

Pjax::begin();

$blockReason = Ref::getList('type,block', 'hipanel');

$widgetIndexConfig = [
    'dataProvider' => $dataProvider,
    'columns'      => [
        [
            'label'  => Yii::t('hipanel', 'Client'),
            'format' => 'raw',
            'value'  => function ($data) {
                return HTML::input('hidden', "ids[{$data->id}][Client][id]", $data->id, ['readonly' => 'readonly', 'disabled' => $data->id === \Yii::$app->user->identity->id || \Yii::$app->user->identity->type === 'client']) . HTML::tag('span', $data->login);
            },
        ],
        [
            'label'  => Yii::t('hipanel', 'Block reason'),
            'format' => 'raw',
            'value'  => function ($data) {
                return Html::dropDownList("ids[{$data->id}][Client][type]", '', Ref::getList('type,block', 'hipanel'), ['promt' => Yii::t('hipanel', 'Select block reason')]);
            },
        ],
        [
            'label'  => Yii::t('hipanel', 'Comment'),
            'format' => 'raw',
            'value'  => function ($data) {
                return Html::input('text', "ids[{$data->id}][Client][comment]", '', ['toggle-title' => Yii::t('hipanel', 'Write comment')]);
            },
        ],
    ],
];
echo GridView::widget($widgetIndexConfig);

Pjax::end();

echo Html::endForm();
