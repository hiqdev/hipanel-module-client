<?php

use hipanel\modules\client\grid\ContactGridView;
use hipanel\widgets\IndexLayoutSwitcher;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\helpers\Html;

$this->title    = Yii::t('app', 'Contact');
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->breadcrumbs->setItems([
    $this->title,
]);
?>
<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

        <?= $page->setSearchFormData() ?>

        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel', 'Create'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('show-actions') ?>
            <?= IndexLayoutSwitcher::widget() ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'email',
                    'name',
                    'client',
                    'seller',
                ],
            ]) ?>
            <?= $page->renderPerPage() ?>
            <?= $page->renderRepresentation() ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), 'delete', 'danger')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= ContactGridView::widget([
                'dataProvider' => $dataProvider,
                'boxed' => false,
                'filterModel'  => $model,
                'columns'      => [
                    'checkbox', 'name', 'email',
                    'client_id', 'seller_id',
                    'actions',
                ],
            ]) ?>
        <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php $page->end() ?>
<?php Pjax::end() ?>
