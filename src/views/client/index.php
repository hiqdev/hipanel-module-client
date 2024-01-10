<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\models\IndexPageUiOptions;
use hipanel\modules\client\grid\ClientGridLegend;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ClientRepresentations;
use hipanel\modules\client\models\ClientSearch;
use hipanel\modules\client\widgets\DeleteClientsByLoginsModal;
use hipanel\modules\stock\helpers\ProfitColumns;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\gridLegend\GridLegend;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use hipanel\helpers\Url;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\bootstrap\Dropdown;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var ClientRepresentations $representationCollection
 * @var ActiveDataProvider $dataProvider
 * @var IndexPageUiOptions $uiModel
 * @var ClientSearch $model
 * @var array $types
 * @var array $states
 * @var array $debt_label
 */

FlagIconCssAsset::register($this);

$this->title = Yii::t('hipanel', 'Clients');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

$showFooter = ($uiModel->representation === 'profit-report')
    && (Yii::$app->user->can('order.read-profits'))
    && (class_exists(ProfitColumns::class));

$user = Yii::$app->user;
$canCreateClients = !$this->context->module->userCreationIsDisabled && ($user->can('client.create') || $user->can('employee.create'));

?>

<?php $page = IndexPage::begin(['model' => $model, 'dataProvider' => $dataProvider]) ?>

    <?php $page->setSearchFormData([
            'types' => $types,
            'states' => $states,
            'uiModel' => $uiModel,
            'debt_label' => $debt_label,
    ]) ?>

    <?php if ($canCreateClients) : ?>
        <?php $page->beginContent('main-actions') ?>
            <?= Html::a(Yii::t('hipanel:client', 'Create client'), ['@client/create'], ['class' => 'btn btn-sm btn-success']) ?>
        <?php $page->endContent() ?>
    <?php endif ?>

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

    <?php $page->beginContent('alt-actions') ?>
        <?= DeleteClientsByLoginsModal::widget() ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?php $dropDownItems = $ajaxModals = [] ?>
        <?php
        if (Yii::$app->user->can('client.block')) {
            $dropDownItems = [
                [
                    'label' => '<i class="fa fa-toggle-on"></i> ' . Yii::t('hipanel', 'Enable block'),
                    'linkOptions' => ['data-toggle' => 'modal'],
                    'url' => '#bulk-enable-block-modal',
                ],
                [
                    'label' => '<i class="fa fa-envelope"></i> ' . Yii::t('hipanel', 'Notification'),
                    'url' => '#bulk-create-notification-modal',
                    'linkOptions' => ['data-toggle' => 'modal'],
                ]
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
                    'id' => 'bulk-create-notification-modal',
                    'scenario' => Url::to('@client/bulk-create-notification-modal'),
                    'bulkPage' => true,
                    'usePost' => true,
                    'header' => Html::tag('h4', Yii::t('hipanel', 'Notification'), ['class' => 'modal-title']),
                    'headerOptions' => ['class' => 'label-warning'],
                    'handleSubmit' => false,
                    'toggleButton' => false,
                ],
            ];
        }
        if (Yii::$app->user->can('client.unblock')) {
            array_push($dropDownItems, [
                'label' => '<i class="fa fa-toggle-off"></i> ' . Yii::t('hipanel', 'Disable block'),
                'url' => '#bulk-disable-block-modal',
                'linkOptions' => ['data-toggle' => 'modal'],
            ]);
            array_push($ajaxModals, [
                'id' => 'bulk-disable-block-modal',
                 'scenario' => 'bulk-disable-block-modal',
                 'bulkPage' => true,
                 'header' => Html::tag('h4', Yii::t('hipanel:client', 'Unblock clients'), ['class' => 'modal-title']),
                 'headerOptions' => ['class' => 'label-warning'],
                 'handleSubmit' => false,
                 'toggleButton' => false,
            ]);
        }
        if (Yii::$app->user->can('client.delete')) {
            array_push($dropDownItems, [
                'label' => '<i class="fa fa-trash"></i> ' . Yii::t('hipanel', 'Delete'),
                'url' => '#bulk-delete-modal',
                'linkOptions' => ['data-toggle' => 'modal'],
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
        if (Yii::$app->user->can('client.update')) {
            echo $page->renderBulkButton('@client/update', Yii::t('hipanel', 'Edit'));
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
                'showFooter' => $showFooter,
                'columns' => $representationCollection->getByName($uiModel->representation)->getColumns(),
            ]) ?>
        <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>

<?php $page->end() ?>
