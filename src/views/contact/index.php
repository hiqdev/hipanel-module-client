<?php

use hipanel\modules\client\grid\ContactGridView;
use hipanel\widgets\ActionBox;

$this->title    = Yii::t('app', 'Contact');
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';
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
<?php $box->end() ?>

<?php $box->beginBulkForm() ?>
    <?= ContactGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'columns'      => [
            'checkbox', 'name', 'email',
            'client_id', 'seller_id',
            'actions',
        ],
    ]) ?>
<?php $box->endBulkForm() ?>
