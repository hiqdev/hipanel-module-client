<?php

use hipanel\grid\ActionColumn;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\widgets\ActionBox;
use yii\helpers\Html;

$this->title    = Yii::t('app', 'Contact');
$this->subtitle = Yii::$app->request->queryParams ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);
?>

<?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
    <?php $box->beginActions() ?>
        <?= $box->renderCreateButton(Yii::t('app', 'Create contact')) ?>
        <?= $box->renderSearchButton() ?>
        <?= $box->renderSorter([
            'attributes' => [
                'email',
                'name',
                'client',
                'seller',
            ],
        ]) ?>
        <?= $box->renderPerPage() ?>
    <?php $box->endActions() ?>
    <?= $box->renderBulkActions([
        'items' => [
            $box->renderDeleteButton(),
        ],
    ]) ?>
    <?= $box->renderSearchForm() ?>
<?php $box::end() ?>

<?php $box->beginBulkForm() ?>
    <?= ContactGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'columns'      => [
            'checkbox', 'name', 'email',
            'client_id', 'seller_id',
            'actions' => [
                'class'    => ActionColumn::className(),
                'template' => '{view} {update} {copy} {delete}',
                'header'   => Yii::t('app', 'Actions'),
                'buttons'  => [
                    'copy' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-copy"></i>' . Yii::t('app', 'Copy'), $url);
                    },
                ],

            ],
        ],
    ]) ?>
<?php $box::endBulkForm() ?>
