<?php

use hipanel\modules\client\grid\BlacklistGridView;
use hipanel\modules\client\grid\BlacklistRepresentations;
use hipanel\modules\client\models\BlacklistSearch;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use hipanel\widgets\AjaxModal;
use yii\bootstrap\Modal;
use hipanel\models\IndexPageUiOptions;

/**
 * @var BlacklistSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var BlacklistRepresentations $representationCollection
 * @var IndexPageUiOptions $uiModel
 * @var array $types
 * @var array $states
 */

$this->title = Yii::t('hipanel', 'Blacklist');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

        <?php $page->setSearchFormData([
            'types' => $types,
            'states' => $states,
        ]) ?>

        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel', 'Create'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('sorter-actions') ?>
            <?= $page->renderSorter([
                'attributes' => [
                    'name',
                    'type',
                ],
            ]) ?>
        <?php $page->endContent() ?>
        <?php $page->beginContent('representation-actions') ?>
            <?= $page->renderRepresentations($representationCollection) ?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('bulk-actions') ?>
            <?= $page->renderBulkDeleteButton('/client/blacklist/delete')?>
        <?php $page->endContent() ?>

        <?php $page->beginContent('table') ?>
            <?php $page->beginBulkForm() ?>
                <?= BlacklistGridView::widget([
                    'dataProvider' => $dataProvider,
                    'boxed' => false,
                    'filterModel'  => $model,
                    'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
                ]) ?>
            <?php $page->endBulkForm() ?>
        <?php $page->endContent() ?>
    <?php IndexPage::end() ?>
<?php Pjax::end() ?>
