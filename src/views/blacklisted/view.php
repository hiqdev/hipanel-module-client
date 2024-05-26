<?php declare(strict_types=1);

/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\modules\client\grid\BlacklistedGridView;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use hipanel\modules\client\models\Blacklisted;
use hipanel\widgets\Box;
use yii\helpers\Html;

/**
 * @var Blacklisted $model
 * @var BlacklistCategoryInterface $blacklistCategory
 */

$this->title = $model->name;
$this->params['subtitle'] = sprintf('%s %s', Yii::t('hipanel:client', $blacklistCategory->getLabel() . ' detailed information'), (Yii::$app->user->can('support') ? ' #' . $model->id : ''));
if (Yii::$app->user->can('client.read')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', $blacklistCategory->getLabel()), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-6">
        <?php $box = Box::begin(['renderBody' => false]) ?>
            <?php $box->beginHeader() ?>
                <?= $box->renderTitle(Yii::t('hipanel:client', $blacklistCategory->getLabel() . ' information')) ?>
                <?php $box->beginTools() ?>
                    <?= Html::a(Yii::t('hipanel', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                <?php $box->endTools() ?>
            <?php Box::endHeader() ?>
            <?php $box->beginBody() ?>
                <?= BlacklistedGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => [
                        'name',
                        'message',
                        'show_message',

                        'type',
                        'client',
                        //'state',

                        'create_time',
                    ],
                ]) ?>
            <?php $box->endBody() ?>
        <?php Box::end() ?>
    </div>
</div>
