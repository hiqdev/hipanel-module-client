<?php

/**
 * @var \yii\web\View $this
 * @var \hiqdev\hiart\ActiveDataProvider $dataProvider
 */

// @var \hipanel\modules\client\models\Client $model
// @var \hipanel\modules\client\models\Client[] $models

$this->title = Yii::t('hipanel:client', 'Assignments');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

use hipanel\modules\client\grid\ClientGridView;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax; ?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>
    <?php $page->beginContent('sorter-actions') ?>
        <?= $page->renderSorter([
            'attributes' => [
                'login',
                'name',
                'seller',
                'type',
                'balance',
                'credit',
                'tariff',
                'create_time',
            ],
        ]) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?= $page->renderBulkButton('update', Yii::t('hipanel', 'Set assignments'), ['color' => 'success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= ClientGridView::widget([
                'boxed' => false,
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'columns' => [
                    'checkbox',
                    'login',
                    'assignments',
                ]
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page->end() ?>
<?php Pjax::end() ?>
