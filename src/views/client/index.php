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
use hipanel\widgets\ActionBox;
use hipanel\widgets\AjaxModal;
use hipanel\widgets\Pjax;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title    = Yii::t('app', 'Clients');
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
                    'seller',
                    'name',
                    'balance',
                    'credit',
                    'tariff',
                    'type',
                    'create_time',
                ],
            ]) ?>
        <?= $box->renderPerPage() ?>
        <?php $box->endActions() ?>
        <?php $box->beginBulkActions() ?>
            <?php if (Yii::$app->user->can('support')) : ?>
                <div class="dropdown" style="display: inline-block">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= Yii::t('app', 'Block') ?>
                        <span class="caret"></span>
                    </button>
                    <?= Dropdown::widget([
                        'encodeLabels' => false,
                        'items' => [
                            [
                                'label' => '<i class="fa fa-toggle-on"></i> ' . Yii::t('app', 'Enable'),
                                'linkOptions' => ['data-toggle' => 'modal'],
                                'url' => '#bulk-enable-block-modal',
                            ],
                            [
                                'label' => '<i class="fa fa-toggle-off"></i> ' . Yii::t('app', 'Disable'),
                                'url' => '#bulk-disable-block-modal',
                                'linkOptions' => ['data-toggle' => 'modal'],
                            ],
                        ],
                    ]); ?>
                    <div class="text-left">
                        <?= AjaxModal::widget([
                            'id' => 'bulk-enable-block-modal',
                            'bulkPage' => true,
                            'header' => Html::tag('h4', Yii::t('hipanel/client', 'Block clients'), ['class' => 'modal-title']),
                            'scenario' => 'bulk-enable-block',
                            'actionUrl' => ['bulk-enable-block-modal'],
                            'size' => Modal::SIZE_LARGE,
                            'handleSubmit' => false,
                            'toggleButton' => false,
                        ]) ?>
                        <?= AjaxModal::widget([
                            'id' => 'bulk-disable-block-modal',
                            'bulkPage' => true,
                            'header' => Html::tag('h4', Yii::t('hipanel/hosting', 'Unblock clients'), ['class' => 'modal-title']),
                            'scenario' => 'bulk-disable-block',
                            'actionUrl' => ['bulk-disable-block-modal'],
                            'size' => Modal::SIZE_LARGE,
                            'handleSubmit' => false,
                            'toggleButton' => false,
                        ]) ?>
                    </div>
            <?php endif; ?>
        <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(compact('states')) ?>
    <?php $box->end() ?>

<?php $box->beginBulkForm() ?>
    <?= ClientGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $model,
        'columns'      => [
            'checkbox',
            'login', 'name', 'seller_id',
            'type', 'state',
            'balance', 'credit',
            'action',
        ],
    ]) ?>
<?php $box->endBulkForm() ?>

<?php Pjax::end() ?>
