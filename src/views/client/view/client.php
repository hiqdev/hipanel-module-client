<?php

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\menus\ClientDetailMenu;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\ClientReferralDetailView;
use hipanel\modules\client\widgets\ClientSwitcher;
use hipanel\modules\client\widgets\ForceVerificationBlock;
use hipanel\modules\document\widgets\StackedDocumentsView;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

/**
 * @var Client $model
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
        <?= $this->render('./../_custom-attributes', ['model' => $model]) ?>
        <?php Box::end() ?>

        <?= ClientReferralDetailView::widget(['client' => $model]) ?>

        <?= ForceVerificationBlock::widget([
            'client' => $model,
            'contact' => $model->contact,
        ]) ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false, 'bodyOptions' => ['class' => 'no-padding']]) ?>
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
                        Yii::$app->user->not($model->id) ? 'description' : null,
                        'language',
                        'type', 'state',
                        'create_time', 'update_time',
                        class_exists(\hipanel\modules\ticket\Module::class) ? 'tickets' : null,
                        class_exists(\hipanel\modules\server\Module::class) ? 'servers' : null,
                        class_exists(\hipanel\modules\domain\Module::class) ? 'domains' : null,
                        'contacts',
                        class_exists(\hipanel\modules\hosting\Module::class) ? 'hosting' : null,
                        class_exists(\hipanel\modules\finance\Module::class) ? 'targets' : null,
                        'blocking',
                        'tags',
                    ]),
                ]) ?>
                <?php $box->endBody() ?>
                <?php $box->end() ?>
                <?php foreach ($model->sortedPurses as $purse) : ?>
                    <?= $this->render('@vendor/hiqdev/hipanel-module-finance/src/views/purse/_client-view', ['model' => $purse]) ?>
                <?php endforeach ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false, 'bodyOptions' => ['class' => 'no-padding']]) ?>
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
                    'columns' => array_filter([
                        'name_with_verification', 'organization_with_warning',
                        'email_with_verification', 'abuse_email', 'messengers', 'social_net',
                        'voice_phone', 'fax_phone',
                        (Yii::getAlias("@kyc", false) !== false ? 'kyc_status' : null),
                        'street', 'city', 'province', 'postal_code', 'country',
                    ]),
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
