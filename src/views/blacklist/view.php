<?php declare(strict_types=1);

/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

use hipanel\modules\client\grid\BlacklistGridView;
use hipanel\modules\client\helpers\blacklist\BlacklistCategory;
use hipanel\modules\client\menus\BlacklistDetailMenu;
use hipanel\modules\client\models\Blacklist;
use hipanel\widgets\Box;
use yii\helpers\Html;

/**
 * @var Blacklist $model
 */

$blacklistCategory = new BlacklistCategory();
$this->title = $model->name;
$this->params['subtitle'] = sprintf('%s %s', Yii::t('hipanel:client', $blacklistCategory->getLabel() . ' detailed information'), (Yii::$app->user->can('support') ? ' #' . $model->id : ''));
if (Yii::$app->user->can('client.read')) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', $blacklistCategory->getLabel()), 'url' => ['index']];
}
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-3">
        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding',
            ],
        ]); ?>
        <div class="profile-user-img text-center">
            <i class="fa fa-ban fa-5x"></i>
        </div>

        <div class="profile-usermenu">
            <?= BlacklistDetailMenu::widget(['model' => $model, 'category' => $blacklistCategory]) ?>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-6">
        <?php $box = Box::begin(['renderBody' => false]) ?>
            <?php $box->beginHeader() ?>
                <?= $box->renderTitle(Yii::t('hipanel:client', $blacklistCategory->getLabel() . ' information')) ?>
            <?php Box::endHeader() ?>
            <?php $box->beginBody() ?>
                <?= BlacklistGridView::detailView([
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
