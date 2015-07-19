<?php

use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\models\Contact;
use hipanel\widgets\Box;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\DetailView;

$this->title    = Inflector::titleize($model->name, true);
$this->subtitle = Yii::t('app', 'client detailed information');
$this->breadcrumbs->setItems([
    ['label' => 'Clients', 'url' => ['index']],
    $this->title,
]);

FlagIconCssAsset::register($this);

?>
<div class="row">
    <div class="col-md-3">
        <?php Box::begin(); ?>
        <div class="profile-user-img text-center">
            <?= $this->render('//layouts/gravatar', ['email' => $model->email, 'size' => 120]); ?>
        </div>
        <p class="text-center">
            <span class="profile-user-name"><?= $this->title; ?></span>
            <br>
            <span class="profile-user-role"><?= $model->type; ?></span
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="ion-unlocked"></i>' . Yii::t('app', 'Change your password'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-network"></i>' . Yii::t('app', 'Changing the IP address restrictions'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-lock-combination"></i>' . Yii::t('app', 'Pincode'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-at"></i>' . Yii::t('app', 'Mailings'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-compose"></i>' . Yii::t('app', 'Change login'), '#'); ?>
                </li>
                <li>
                    <?= Html::a('<i class="ion-wrench"></i>' . Yii::t('app', 'Change type'), '#'); ?>
                </li>
            </ul>
        </div>
        <?php Box::end(); ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]); ?>
                <?php $box->beginHeader(); ?>
                <?= $box->renderTitle(Yii::t('app', 'Contact information')); ?>
                <?php $box->beginTools(); ?>
                <?= Html::a(Yii::t('app', 'Change contact information'), '#', ['class' => 'btn btn-default btn-xs']); ?>
                <?php $box->endTools(); ?>
                <?php $box->beginBody(); ?>
                <?= ContactGridView::detailView([
                    'model'   => new Contact($model->contact),
                    'columns' => [
                        'email',
                        'abuse_email',
                        'skype',
                        'icq',
                        'jabber',
                        'voice_phone',
                        'fax',
                        'country',
                        'province',
                        'postal_code',
                        'city',
                        'street',
                        /// RU/SU
                        'passport_no',
                        'passport_date',
                        'passport_by',
                        'organization',
                    ],
                ]) ?>
                <?php $box->endBody(); ?>
                <?php $box->endHeader(); ?>
                <?php $box::end(); ?>
            </div>
            <div class="col-md-6">
                <?php
                $box = Box::begin(['renderBody' => false]);

                $box->beginHeader();
                echo $box->renderTitle(Yii::t('app', 'Billing information'), '47 items');
                $box->beginTools();
                echo Html::a(Yii::t('app', 'Recharge account'), '#', ['class' => 'btn btn-default btn-xs']);
                $box->endTools();
                $box->endHeader();

                $box->beginBody();
                echo DetailView::widget([
                    'model'      => $model,
                    'attributes' => [
                        'state',
                        'balance',
                        'credit',
                        'tariff',
                        'type',
                    ],
                ]);
                $box->endBody();
                $box::end(); ?>
            </div>
        </div>
    </div>
</div>
