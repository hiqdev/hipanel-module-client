<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\modules\client\grid\ClientGridLegend;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;

$this->title = Yii::t('hipanel', 'Clients');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?= $page->setSearchFormData(compact(['types', 'states'])) ?>

    <?php $page->beginContent('main-actions') ?>
        <?= Html::a(Yii::t('hipanel:client', 'Create client'), ['@client/create'], ['class' => 'btn btn-sm btn-success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('legend') ?>
        <?= GridLegend::widget(['legendItem' => new ClientGridLegend($model)]) ?>
    <?php $page->endContent() ?>

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
    <?php $page->beginContent('representation-actions') ?>
        <?= $page->renderRepresentations($representationCollection) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?php if (Yii::$app->user->can('support')) : ?>
            <?php if ($uiModel->representation === 'payment') : ?>
                <?= $page->renderBulkButton(Yii::t('hipanel:client', 'Payment notification'), 'create-payment-ticket', 'danger')?>
            <?php endif ?>
            <?php
            $dropDownItems = [
                [
                    'label' => '<i class="fa fa-toggle-on"></i> ' . Yii::t('hipanel', 'Enable block'),
                    'linkOptions' => ['data-toggle' => 'modal'],
                    'url' => '#bulk-enable-block-modal',
                ],
                [
                    'label' => '<i class="fa fa-toggle-off"></i> ' . Yii::t('hipanel', 'Disable block'),
                    'url' => '#bulk-disable-block-modal',
                    'linkOptions' => ['data-toggle' => 'modal'],
                ],
            ];
            $ajaxModals = [
                [
                    'id' => 'bulk-enable-block-modal',
                    'scenario' => 'bulk-enable-block-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel:client', 'Block clients'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-warning'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ],
                [
                    'id' => 'bulk-disable-block-modal',
                    'scenario' => 'bulk-disable-block-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel:client', 'Unblock clients'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-warning'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ],
            ];
            if (Yii::$app->user->can('manage')) {
                array_push($dropDownItems, [
                    'label' => '<i class="fa fa-trash"></i> ' . Yii::t('hipanel', 'Delete'),
                    'url' => '#bulk-delete-modal',
                    'linkOptions' => ['data-toggle' => 'modal']
                ]);
                array_push($ajaxModals, [
                    'id' => 'bulk-delete-modal',
                    'scenario' => 'bulk-delete-modal',
                    'bulkPage' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel', 'Delete'), ['class' => 'modal-title label-danger']),
                    'headerOptions' => ['class' => 'label-danger'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ]);
            }
            if (Yii::$app->user->can('manage')) {
                echo $page->renderBulkButton(Yii::t('hipanel', 'Edit'), 'update');
            }
            ?>
            <div class="dropdown" style="display: inline-block">
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= Yii::t('hipanel', 'Basic actions') ?>
                    <span class="caret"></span>
                </button>
                <?= Dropdown::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'pull-right'],
                    'items' => $dropDownItems,
                ]) ?>
                <div class="text-left">
                    <?php foreach ($ajaxModals as $ajaxModal) : ?>
                        <?= AjaxModal::widget($ajaxModal) ?>
                    <?php endforeach ?>
               </div>
            </div>
        <?php endif ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
        <?php $page->beginBulkForm() ?>
            <?= ClientGridView::widget([
                'boxed' => false,
                'rowOptions' => function ($model) {
                    return  GridLegend::create(new ClientGridLegend($model))->gridRowOptions();
                },
                'dataProvider' => $dataProvider,
                'filterModel'  => $model,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>

<?php $page->end() ?>
<?php Pjax::end() ?>
