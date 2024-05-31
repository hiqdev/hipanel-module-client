<?php

use hipanel\modules\client\grid\BlacklistRepresentations;
use hipanel\modules\client\grid\WhitelistGridView;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use hipanel\modules\client\models\BlacklistSearch;
use hipanel\widgets\IndexPage;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use hipanel\models\IndexPageUiOptions;

/**
 * @var BlacklistSearch $model
 * @var ActiveDataProvider $dataProvider
 * @var BlacklistRepresentations $representationCollection
 * @var IndexPageUiOptions $uiModel
 * @var array $types
 * @var BlacklistCategoryInterface $blacklistCategory
 */

$this->title = Yii::t('hipanel', $blacklistCategory->getLabel());
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData([
        'types' => $types,
    ]) ?>

    <?php $page->beginContent('main-actions') ?>
        <?= Html::a(Yii::t('hipanel', 'Create'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'name',
                'type',
                'message',
                'client',
                'created',
            ],
        ]) ?>
    <?php $page->endContent() ?>
    <?php $page->beginContent('representation-actions') ?>
        <?= $page->renderRepresentations($representationCollection) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= $page->renderBulkDeleteButton('@whitelist/delete')?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= WhitelistGridView::widget([
                'dataProvider' => $dataProvider,
                'boxed' => false,
                'filterModel'  => $model,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php IndexPage::end() ?>
