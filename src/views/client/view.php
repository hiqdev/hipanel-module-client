<?php

use hipanel\helpers\FontIcon;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;
use hipanel\widgets\BlockModalButton;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hipanel\widgets\SettingsModal;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

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
        ]); ?>
        <div class="profile-user-img text-center">
            <?= $this->render('//layouts/gravatar', ['email' => $model->email, 'size' => 120]); ?>
        </div>
        <p class="text-center">
            <span class="profile-user-name">
                <?= ClientSellerLink::widget([
                    'model' => $model,
                    'clientAttribute' => 'login',
                    'clientIdAttribute' => 'id',
                ]) ?>
            </span>
            <br>
            <span class="profile-user-role"><?= $model->type ?></span><br>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <?php if (Yii::$app->user->is($model->id)) : ?>
                    <li>
                        <a href="http://gravatar.com" target="_blank">
                            <i><img src="https://www.gravatar.com/avatar/00000000000000000000000000000000/?s=17" /></i>
                            <?= Yii::t('hipanel:client', 'You can change your avatar at Gravatar.com')?>
                        </a>
                    </li>
                <?php endif ?>
                <?php if (Yii::$app->user->is($model->id)) : ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('hipanel', 'Change password'),
                            'icon'     => 'fa-key fa-flip-horizontal fa-fw',
                            'scenario' => 'change-password',
                        ]) ?>
                    </li>
                <?php endif ?>
                <?php if (Yii::$app->user->not($model->id) && Yii::$app->user->can('manage')) : ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('hipanel:client', 'Temporary password'),
                            'icon'     => 'fa-key fa-flip-horizontal fa-fw',
                            'scenario' => 'set-tmp-password',
                        ]) ?>
                    </li>
                <?php endif ?>
                <?php if (Yii::$app->user->is($model->id)) : ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('hipanel:client', 'Pincode settings'),
                            'icon'     => 'fa-puzzle-piece fa-fw',
                            'scenario' => 'pincode-settings',
                        ]) ?>
                    </li>
                <?php endif ?>
                <?php if (Yii::$app->user->is($model->id)) : ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('hipanel:client', 'IP address restrictions'),
                            'icon'     => 'fa-arrows-alt fa-fw',
                            'scenario' => 'ip-restrictions',
                        ]) ?>
                    </li>
                <?php endif ?>
                <li>
                    <?= SettingsModal::widget([
                        'model'    => $model,
                        'title'    => Yii::t('hipanel:client', 'Mailing settings'),
                        'icon'     => 'fa-envelope fa-fw',
                        'scenario' => 'mailing-settings',
                    ]) ?>
                </li>
                <li>
                    <?= Html::a(FontIcon::i('fa-edit fa-fw') . Yii::t('hipanel:client', 'Change contact information'), ['@contact/update', 'id' => $model->id]) ?>
                </li>
                <?php if (Yii::getAlias('@domain', false)) : ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('hipanel:client', 'Domain settings'),
                            'icon'     => 'fa-globe fa-fw',
                            'scenario' => 'domain-settings',
                        ]) ?>
                    </li>
                <?php endif ?>
                <?php if (Yii::getAlias('@ticket', false)) : ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('hipanel:ticket', 'Ticket settings'),
                            'icon'     => 'fa-ticket fa-fw',
                            'scenario' => 'ticket-settings',
                        ]) ?>
                    </li>
                <?php endif ?>
                <?php if (Yii::$app->user->can('support') && Yii::$app->user->not($model->id)) : ?>
                    <li>
                        <?= BlockModalButton::widget(compact('model')) ?>
                    </li>
                <?php endif ?>
            </ul>
        </div>
        <?php Box::end(); ?>
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
                        <?= $this->render('@hipanel/modules/finance/views/bill/_purseBlock', compact('purse')) ?>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]); ?>
                    <?php $box->beginHeader(); ?>
                        <?= $box->renderTitle(Yii::t('hipanel:client', 'Contact information'), ''); ?>
                        <?php $box->beginTools(); ?>
                            <?= Html::a(Yii::t('hipanel', 'Details'), ['@contact/view', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                            <?= Html::a(Yii::t('hipanel', 'Change'), ['@contact/update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                        <?php $box->endTools(); ?>
                    <?php $box->endHeader(); ?>
                    <?php $contact = new Contact(); $contact->load($model->contact, ''); ?>
                    <?php $box->beginBody(); ?>
                        <?= ContactGridView::detailView([
                            'boxed' => false,
                            'model' => $contact,
                            'columns' => [
                                'first_name', 'last_name', 'organization',
                                'email', 'abuse_email', 'messengers', 'social_net',
                                'voice_phone', 'fax_phone',
                                'street', 'city', 'province', 'postal_code', 'country',
                            ],
                        ]) ?>
                    <?php $box->endBody(); ?>
                <?php $box->end(); ?>
            </div>
        </div>
    </div>
</div>
