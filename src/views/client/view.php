<?php

use hipanel\modules\client\models\Client;
use hipanel\widgets\BlockModalButton;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\models\Contact;
use hipanel\modules\finance\models\Purse;
use hipanel\modules\finance\grid\PurseGridView;
use hipanel\widgets\Box;
use hipanel\widgets\SettingsModal;
use hipanel\helpers\FontIcon;
use yii\helpers\Html;


/**
 * @var $model Client
 */


$this->title = $model->login;
$this->subtitle = Yii::t('app', 'Client detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('app', 'Clients'), 'url' => ['index']],
    $this->title,
]);

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
            <span class="profile-user-name"><?= $model->login . ' / ' . $model->seller ?></span>
            <br>
            <span class="profile-user-role"><?= $model->type ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= SettingsModal::widget([
                        'model'    => $model,
                        'title'    => Yii::t('app', 'Change password'),
                        'icon'     => 'fa-key fa-flip-horizontal fa-fw',
                        'scenario' => 'change-password',
                    ]) ?>
                </li>
                <?php if (Yii::$app->user->id == $model->id) { ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('app', 'Pincode settings'),
                            'icon'     => 'fa-puzzle-piece fa-fw',
                            'scenario' => 'pincode-settings',
                        ]) ?>
                    </li>
                <?php } ?>
                <li>
                    <?= SettingsModal::widget([
                        'model'    => $model,
                        'title'    => Yii::t('app', 'IP address restrictions'),
                        'icon'     => 'fa-arrows-alt fa-fw',
                        'scenario' => 'ip-restrictions',
                    ]) ?>
                </li>
                <li>
                    <?= SettingsModal::widget([
                        'model'    => $model,
                        'title'    => Yii::t('app', 'Mailing settings'),
                        'icon'     => 'fa-envelope fa-fw',
                        'scenario' => 'mailing-settings',
                    ]) ?>
                </li>
                <li>
                    <?= Html::a(FontIcon::i('fa-edit fa-fw') . Yii::t('app', 'Change contact information'), ['@contact/update', 'id' => $model->id]) ?>
                </li>
                <?php if (Yii::getAlias('@domain', false)) { ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('app', 'Domain settings'),
                            'icon'     => 'fa-globe fa-fw',
                            'scenario' => 'domain-settings',
                        ]) ?>
                    </li>
                <?php } ?>
                <?php if (Yii::getAlias('@ticket', false)) { ?>
                    <li>
                        <?= SettingsModal::widget([
                            'model'    => $model,
                            'title'    => Yii::t('app', 'Ticket settings'),
                            'icon'     => 'fa-ticket fa-fw',
                            'scenario' => 'ticket-settings',
                        ]) ?>
                    </li>
                <?php } ?>
                <?php if (Yii::$app->user->can('support') && Yii::$app->user->not($model->id)) { ?>
                    <li>
                        <?= BlockModalButton::widget(compact('model')) ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                        <?= $box->renderTitle(Yii::t('app', 'Client information'), '&nbsp;') ?>
                        <?php $box->beginTools() ?>
                        <?php $box->endTools() ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                        <?= ClientGridView::detailView([
                            'boxed' => false,
                            'model' => $model,
                            'columns' => [
                                'seller_id', 'name',
                                'type', 'state',
                                'create_time', 'update_time',
                                'tickets', 'servers', 'domains', 'contacts', 'hosting',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>
                <?php foreach ($model->purses as $purse) { ?>
                    <?php if ($purse['balance']===null) {
                        continue;
                    } ?>
                    <?php $box = Box::begin(['renderBody' => false]) ?>
                        <?php $box->beginHeader() ?>
                            <?= $box->renderTitle(Yii::t('app', '<b>{currency}</b> account', ['currency' => strtoupper($purse['currency'])]), '&nbsp;') ?>
                            <?php $box->beginTools() ?>
                                <?php if (Yii::$app->user->can('support')) { ?>
                                    <?= Html::a(Yii::t('app', 'Generate invoice'), ['@purse/generate-invoice', 'id' => $purse['id']], ['class' => 'btn btn-default btn-xs']) ?>
                                <?php } else { ?>
                                    <?= Html::a(Yii::t('app', 'Recharge account'), '#', ['class' => 'btn btn-default btn-xs']) ?>
                                <?php } ?>
                            <?php $box->endTools() ?>
                        <?php $box->endHeader() ?>
                        <?php $box->beginBody() ?>
                            <?= PurseGridView::detailView([
                                'boxed' => false,
                                'model' => new Purse($purse),
                                'columns' => $purse['currency']=='usd'
                                    ? ['balance', 'credit', 'invoices']
                                    : ['balance', 'invoices']
                                ,
                            ]) ?>
                        <?php $box->endBody() ?>
                    <?php $box->end() ?>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]); ?>
                    <?php $box->beginHeader(); ?>
                        <?= $box->renderTitle(Yii::t('app', 'Contact information'), ''); ?>
                        <?php $box->beginTools(); ?>
                            <?= Html::a(Yii::t('app', 'Details'), ['@contact/view', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                            <?= Html::a(Yii::t('app', 'Change'), ['@contact/update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                        <?php $box->endTools(); ?>
                    <?php $box->endHeader(); ?>
                    <?php $box->beginBody(); ?>
                        <?= ContactGridView::detailView([
                            'boxed' => false,
                            'model' => new Contact($model->contact),
                            'columns' => [
                                'first_name', 'last_name', 'organization',
                                'email', 'abuse_email', 'messengers',
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
