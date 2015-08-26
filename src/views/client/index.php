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
use hipanel\widgets\Pjax;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\ButtonGroup;

$this->title    = Yii::t('app', 'Clients');
$this->subtitle = Yii::$app->request->queryParams ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);

?>

<? Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>
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
        <? if (Yii::$app->user->can('manage')) { ?>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= Yii::t('app', 'Block') ?> <span class="caret"></span>
                </button>
                <div class="dropdown-menu dropdown-content pull-right">
                    <?= ButtonGroup::widget([
                        'buttons' => [
                            $box->renderBulkButton(Yii::t('app', 'Enable'), ''),
                            $box->renderBulkButton(Yii::t('app', 'Disable'), ''),
                        ]
                    ]); ?>
                </div>
            </div>
        <? } ?>
        <?php $box->endBulkActions() ?>
        <?= $box->renderSearchForm(compact('state_data')) ?>
    <?php $box::end() ?>

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
<?php $box::endBulkForm() ?>
<?php Pjax::end() ?>
