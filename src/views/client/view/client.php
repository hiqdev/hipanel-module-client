<?php

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\menus\ClientDetailMenu;
use hipanel\modules\client\widgets\ClientSwitcher;
use hipanel\modules\client\widgets\ForceVerificationBlock;
use hipanel\modules\document\widgets\StackedDocumentsView;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

/*
 * @var $model Client
 */

FlagIconCssAsset::register($this);

$this->registerCss('legend {font-size: 16px;}');

?>
<div class="row">
    <div class="col-md-3">

        <?= ClientSwitcher::widget(['model' => $model]) ?>

        <?php Box::begin([
            'options' => [
                'class' => 'box-solid',
            ],
            'bodyOptions' => [
                'class' => 'no-padding',
            ],
        ]) ?>
        <div class="profile-user-img text-center">
            <?= $this->render('//layouts/gravatar', ['email' => $model->email, 'size' => 120]) ?>
        </div>
        <p class="text-center">
            <span class="profile-user-name">
                <?= ClientSellerLink::widget(['model' => $model]) ?>
            </span>
            <br>
            <span class="profile-user-role"><?= $model->type ?></span><br>
        </p>

        <div class="profile-usermenu">
            <?= ClientDetailMenu::widget(['model' => $model]) ?>
        </div>
        <?php Box::end() ?>

        <?= ForceVerificationBlock::widget([
            'client' => $model,
            'contact' => $model->contact,
        ]) ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                <?php $box->beginHeader() ?>
                <?= $box->renderTitle(Yii::t('hipanel:client', 'Client information'), '&nbsp;') ?>
                <?php $box->beginTools() ?>
                <?php $box->endTools() ?>
                <?php $box->endHeader() ?>
                <?php $box->beginBody() ?>
                <?= ClientGridView::detailView([
                    'boxed' => false,
                    'model' => $model,
                    'columns' => array_filter([
                        'seller_id', 'referer_id', 'name',
                        Yii::$app->user->not($model->id) ? 'note' : null,
                        'language',
                        'type', 'state',
                        'create_time', 'update_time',
                        'tickets', 'servers', 'domains', 'contacts', 'hosting', 'blocking',
                    ]),
                ]) ?>
                <?php $box->endBody() ?>
                <?php $box->end() ?>
                <?php foreach ($model->sortedPurses as $purse) : ?>
                    <?php if (empty($purse->count)) continue ?>
                    <?= $this->render('@vendor/hiqdev/hipanel-module-finance/src/views/purse/_client-view', ['model' => $purse]) ?>
                <?php endforeach ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                <?php $box->beginHeader() ?>
                <?= $box->renderTitle(Yii::t('hipanel:client', 'Contact information')) ?>
                <?php $box->beginTools() ?>
                <?= Html::a(Yii::t('hipanel', 'Details'), ['@contact/view', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                <?= Html::a(Yii::t('hipanel', 'Change'), ['@contact/update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                <?php $box->endTools() ?>
                <?php $box->endHeader() ?>
                <?php $box->beginBody() ?>
                <?= ContactGridView::detailView([
                    'boxed' => false,
                    'model' => $model->contact,
                    'columns' => [
                        'name_with_verification', 'organization',
                        'email_with_verification', 'abuse_email', 'messengers', 'social_net',
                        'voice_phone', 'fax_phone',
                        'street', 'city', 'province', 'postal_code', 'country',
                    ],
                ]) ?>
                <?php $box->endBody() ?>
                <?php $box->end() ?>

                <?php if (Yii::getAlias('@document', false) !== false && Yii::$app->user->can('document.read')) : ?>
                    <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Yii::t('hipanel:client', 'Documents')) ?>
                    <?php $box->beginTools() ?>
                    <?= Html::a(Yii::t('hipanel', 'Details'), ['@contact/attach-documents', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= Html::a(Yii::t('hipanel', 'Upload'), ['@contact/attach-documents', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                    <?php $box->endTools() ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                    <?= StackedDocumentsView::widget([
                        'models' => $model->contact->documents,
                    ]) ?>
                    <?php $box->endBody() ?>
                    <?php $box->end() ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJs(<<<JS
window.addEventListener('load', function() {
    var anchor = location.hash.slice(1);
    if (!anchor) {
        return;
    }

    var menuItem = $('[data-anchor=' + anchor + ']');
    if (!menuItem) {
        return;
    }

    var modal = $(menuItem.data('target'));
    if (modal.length === 0) {
        return;
    }
    modal.modal();
})
JS
);
?>
