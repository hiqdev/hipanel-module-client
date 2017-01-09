<?php

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\menus\ClientDetailMenu;
use hipanel\modules\client\widgets\ForceVerificationBlock;
use hipanel\modules\document\widgets\StackedDocumentsView;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/*
 * @var $model Client
 */

$this->title = $model->login;
$this->params['subtitle'] = Yii::t('hipanel:client', 'Client detailed information') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

FlagIconCssAsset::register($this);

$this->registerCss('legend {font-size: 16px;}');

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
            'model' => $model->contact,
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
                            'columns' => [
                                'seller_id', 'name', 'note',
                                'type', 'state',
                                'create_time', 'update_time',
                                'tickets', 'servers', 'domains', 'contacts', 'hosting',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>
                <?php foreach ($model->purses as $purse) : ?>
                    <?php if (isset($purse['balance'])) : ?>
                        <?= $this->render('@hipanel/modules/finance/views/bill/_purseBlock', ['model' => $purse]) ?>
                    <?php endif ?>
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

                <?php if (Yii::getAlias('@document', false) !== false) : ?>
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
                                'models' => $model->contact->documents
                            ]) ?>
                        <?php $box->endBody() ?>
                    <?php $box->end() ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
