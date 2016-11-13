<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\modules\client\grid\ClientGridView;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\IndexPage;
use hipanel\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('hipanel', 'Clients');
$this->params['subtitle'] = array_filter(Yii::$app->request->get($model->formName(), [])) ? Yii::t('hipanel', 'filtered list') : Yii::t('hipanel', 'full list');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
<?php $page = IndexPage::begin(compact('model', 'dataProvider')) ?>

    <?= $page->setSearchFormData(compact(['types', 'states'])) ?>

    <?php $page->beginContent('main-actions') ?>
        <?= Html::a(Yii::t('hipanel:client', 'Create client'), 'create', ['class' => 'btn btn-sm btn-success']) ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('show-actions') ?>
        <?= $page->renderLayoutSwitcher() ?>
        <?= $page->renderSorter([
            'attributes' => [
                'seller',
                'name',
                'balance',
                'credit',
                'tariff',
                'type',
                'create_time',
            ],
        ]) ?>
        <?= $page->renderPerPage() ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('bulk-actions') ?>
        <?php if (Yii::$app->user->can('support')) : ?>
            <div class="dropdown" style="display: inline-block">
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= Yii::t('hipanel', 'Block') ?>
                    <span class="caret"></span>
                </button>
                <?= Dropdown::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'pull-right'],
                    'items' => [
                        [
                            'label' => '<i class="fa fa-toggle-on"></i> ' . Yii::t('hipanel', 'Enable'),
                            'linkOptions' => ['data-toggle' => 'modal'],
                            'url' => '#bulk-enable-block-modal',
                        ],
                        [
                            'label' => '<i class="fa fa-toggle-off"></i> ' . Yii::t('hipanel', 'Disable'),
                            'url' => '#bulk-disable-block-modal',
                            'linkOptions' => ['data-toggle' => 'modal'],
                        ],
                    ],
                ]) ?>
                <div class="text-left">
                    <?= AjaxModal::widget([
                        'id' => 'bulk-enable-block-modal',
                        'bulkPage' => true,
                        'header' => Html::tag('h4', Yii::t('hipanel:client', 'Block clients'), ['class' => 'modal-title']),
                        'scenario' => 'bulk-enable-block',
                        'actionUrl' => ['bulk-enable-block-modal'],
                        'size' => Modal::SIZE_LARGE,
                        'handleSubmit' => false,
                        'toggleButton' => false,
                    ]) ?>
                    <?= AjaxModal::widget([
                        'id' => 'bulk-disable-block-modal',
                        'bulkPage' => true,
                        'header' => Html::tag('h4', Yii::t('hipanel:client', 'Unblock clients'), ['class' => 'modal-title']),
                        'scenario' => 'bulk-disable-block',
                        'actionUrl' => ['bulk-disable-block-modal'],
                        'size' => Modal::SIZE_LARGE,
                        'handleSubmit' => false,
                        'toggleButton' => false,
                    ]) ?>
                </div>
            </div>
        <?php endif ?>
        <?php if (Yii::$app->user->can('manage')) : ?>
            <?= $page->renderBulkButton(Yii::t('hipanel', 'Delete'), 'delete', 'danger') ?>
        <?php endif ?>
    <?php $page->endContent() ?>

    <?php $page->beginContent('table') ?>
    <?php $page->beginBulkForm() ?>
    <?= ClientGridView::widget([
        'boxed' => false,
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'columns'      => [
            'checkbox',
            'login',
            'name', 'seller_id',
            'type', 'state',
            'balance', 'credit',
        ],
    ]) ?>
    <?php $page->endBulkForm() ?>
    <?php $page->endContent() ?>

<?php $page->end() ?>
<?php Pjax::end() ?>
