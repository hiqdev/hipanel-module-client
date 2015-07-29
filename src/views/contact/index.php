<?php

use hipanel\grid\ActionColumn;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\widgets\ActionBox;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title    = Yii::t('app', 'Contact');
$this->subtitle = Yii::$app->request->queryParams ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);
?>

<?= Html::beginForm(); ?>

<?php $box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]) ?>
<?php $box->beginActions(); ?>

    <?= Html::a(Yii::t('app', 'Create {modelClass}', ['modelClass' => Yii::t('app', 'Contact')]), ['create'], ['class' => 'btn btn-primary']) ?>&nbsp;

<?php $box->endActions(); ?>
<?php $box->beginBulkActions(); ?>

    <?= Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]) ?>

<?php $box->endBulkActions(); ?>
<?php $box::end(); ?>

<?= ContactGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        'name',
        [
            'attribute' => 'client_id',
            'value'     => function ($model) {
                return Html::a($model->client, ['/client/client/view', 'id' => $model->client_id]);
            },
            'filter' => \hipanel\modules\client\widgets\combo\ClientCombo::widget([
                'attribute'           => 'client_id',
                'model'               => $searchModel,
                'formElementSelector' => 'td',
                'inputOptions'        => [
                    'id' => 'client_id',
                ],
            ]),
            'format' => 'raw',
        ],
        'email',
        [
            'attribute' => 'seller_id',
            'value'     => function ($model) {
                return Html::a($model->seller, ['/client/client/view', 'id' => $model->seller_id]);
            },
            'filter' => \hipanel\modules\client\widgets\combo\SellerCombo::widget([
                'attribute'           => 'seller_id',
                'model'               => $searchModel,
                'formElementSelector' => 'td',
                'inputOptions'        => [
                    'id' => 'seller_id',
                ],
            ]),
            'format' => 'raw',
        ],
        'actions' => [
            'class' => ActionColumn::className(),
            'template' => '{view} {update} {delete}',
            'header' => Yii::t('app', 'Actions'),

        ],
        'checkbox',
    ],
]); ?>

<?= Html::endForm(); ?>
