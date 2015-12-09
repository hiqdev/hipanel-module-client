<?php

use hipanel\modules\client\grid\ArticleGridView;
use hipanel\widgets\ActionBox;
use hipanel\widgets\Pjax;
use hiqdev\combo\StaticCombo;
use yii\helpers\Html;

$this->title = Yii::t('app', 'News and articles');
$this->subtitle = array_filter(Yii::$app->request->get($model->formName(), [])) ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
    <?php $box = ActionBox::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>
        <?php $box->beginActions() ?>
            <?= $box->renderCreateButton(Yii::t('app', 'Create client')) ?>
            <?= $box->renderSearchButton() ?>
            <?= $box->renderSorter([
                'attributes' => [
                    'article_name',
                    'post_date',
                ],
            ]) ?>
            <?= $box->renderPerPage() ?>
        <?php $box->endActions() ?>
        <?= $box->renderSearchForm() ?>
    <?php $box->end() ?>
    <?php $box->beginBulkForm() ?>
    <?= ArticleGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'columns'      => [
            'article_name',
            'post_date',
            'is_published' => [
                'value' => function ($model) {
                    return $model->is_published == 't' ?
                        Html::tag('span', Yii::t('app', 'Published'), ['class' => 'label label-success']) :
                        Html::tag('span', Yii::t('app', 'Unpublished'), ['class' => 'label label-warning']);
                },
                'format' => 'html',
                'filter' => StaticCombo::widget([
                    'attribute' => 'is_published',
                    'model' => $model,
                    'data' => [
                        't' => Yii::t('app', 'Published'),
                        'f' => Yii::t('app', 'Unpublished'),
                    ],
                    'hasId' => true,
                    'inputOptions'        => [
                        'id' => 'responsible_id',
                    ],
                    'pluginOptions' => [
                        'select2Options' => [
                            'multiple' => false,
                        ],
                    ],
                ]),
            ],
        ],
    ]) ?>
    <?php $box->endBulkForm() ?>
<?php Pjax::end() ?>
