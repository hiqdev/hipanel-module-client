<?php

use hipanel\grid\DataColumn;
use hipanel\helpers\Url;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\models\Client;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use hiqdev\hiart\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 * @var Client $model
 * @var Client[] $models
 */

$this->title = Yii::t('hipanel:client', 'Assignments');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
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
                    [
                        'class' => DataColumn::class,
                        'format' => 'raw',
                        'headerOptions' => [
                            'style' => 'text-align: center; vertical-align: middle; width: 1em;',
                        ],
                        'contentOptions' => [
                            'style' => 'text-align: center; vertical-align: middle;',
                        ],
                        'value' => static fn(Client $model): string => Html::a(
                            Html::tag('i', null, ['class' => 'fa fa-pencil']),
                            Url::toRoute(['@client/assignments/update', 'id' => $model->id]),
                            ['class' => 'btn bg-olive btn-xs btn-flat']
                        ),
                    ],
                    [
                        'attribute' => 'login',
                        'filterAttribute' => 'login_like',
                    ],
                    'seller',
                    'type',
                    'assignments',
                ]
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>
<?php $page::end() ?>
<?php Pjax::end() ?>
