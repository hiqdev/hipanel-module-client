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
use hipanel\modules\client\models\Client;
use hipanel\widgets\ActionBox;
use hipanel\widgets\BulkButtons;
use hipanel\widgets\Pjax;
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;

$this->title    = Yii::t('app', 'Clients');
$this->subtitle = Yii::$app->request->queryParams ? 'filtered list' : 'full list';
$this->breadcrumbs->setItems([
    $this->title,
]);

?>

<? Pjax::begin(array_merge(Yii::$app->params['pjax'], ['enablePushState' => true])) ?>

    <?php $box = ActionBox::begin(['bulk' => true, 'options' => ['class' => 'box-info']]) ?>
        <?php $box->beginActions() ?>
            <?= Html::a(Yii::t('app', 'Advanced search'), '#', ['class' => 'btn btn-info search-button']) ?>
        <?php $box->endActions() ?>
        <?php $box->beginBulkActions() ?>
            <?= BulkButtons::widget([
                'model' => new Client,
                'items' => [
                    ButtonDropdown::widget([
                        'label' => Yii::t('app', 'Block'),
                        'dropdown' => [
                            'items' => [
                                [
                                    'label' => Yii::t('app', 'Enable block'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'whois_protected',
                                        'data-value' => '1',
                                        'data-url' => 'set-whois-protect'
                                    ],
                                ],
                                [
                                    'label' => Yii::t('app', 'Disable block'),
                                    'url' => '#',
                                    'linkOptions' => [
                                        'class' => 'bulk-action',
                                        'data-attribute' => 'whois_protected',
                                        'data-value' => '0',
                                        'data-url' => 'set-whois-protect'
                                    ],
                                ],
                            ],
                        ],
                    ]),
                ],
            ]) ?>
            &nbsp;
        <?php $box->endBulkActions() ?>
        <?= $this->render('_search', compact('model')) ?>
    <?php $box::end() ?>


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

<? Pjax::end() ?>
