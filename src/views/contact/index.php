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
    <?= Html::a(Yii::t('app', 'Advanced search'), '#', ['class' => 'btn btn-default search-button']) ?>
<?php $box->endActions(); ?>
<?php $box->beginBulkActions(); ?>
    <?= Html::submitButton(Yii::t('app', 'Delete'), ['class' => 'btn btn-danger', 'formmethod' => 'POST', 'formaction' => Url::to('delete')]) ?>
<?php $box->endBulkActions(); ?>
    <?= $this->render('_search', compact('model')) ?>
<?php $box::end(); ?>

<?= ContactGridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $model,
    'columns'      => [
        'checkbox', 'name', 'email',
        'client_id', 'seller_id',
        'actions' => [
            'class' => ActionColumn::className(),
            'template' => '{view} {update} {copy} {delete}',
            'header' => Yii::t('app', 'Actions'),
            'buttons' => [
                'copy' => function ($url, $model, $key) {
                    return Html::a('<i class="fa fa-copy"></i>' . Yii::t('yii', 'Copy'), $url);
                }
            ],

        ],
    ],
]); ?>

<?= Html::endForm(); ?>
