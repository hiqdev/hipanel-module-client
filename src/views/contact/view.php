<?php

use hipanel\widgets\Box;
use hipanel\modules\client\grid\ContactGridView;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\widgets\DetailView;

$this->title    = Inflector::titleize($model->name, true);
$this->subtitle = Yii::t('app', 'contact detailed information') . ' #'.$model->id;
$this->breadcrumbs->setItems([
    ['label' => 'Contacts', 'url' => ['index']],
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
            <span class="profile-user-role"><?= $this->title ?></span>
            <br>
            <span class="profile-user-name"><?= $model->seller . ' / ' . $model->client; ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="ion-wrench"></i>' . Yii::t('app', 'Change contact information'), '#') ?>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-globe"></i>' . Yii::t('app', 'Used for domains: ') . Html::tag('b', 3), '#') ?>
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
                    <?php $box->endHeader(); ?>
                    <?php $box->beginBody(); ?>
                        <?= ContactGridView::detailView([
                            'model'   => $model,
                            'columns' => [
                                'seller_id',
                                'client_id',
                                ['attribute' => 'name'],
                                'email',
                                'abuse_email',
                                'voice_phone',
                                'fax_phone',
                                'skype',
                                'icq',
                                'jabber',
                                'country',
                            ],
                        ]) ?>
                    <?php $box->endBody(); ?>
                <?php $box::end(); ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]); ?>
                    <?php $box->beginHeader(); ?>
                        <?= $box->renderTitle(Yii::t('app', 'Postal information')); ?>
                    <?php $box->endHeader(); ?>
                    <?php $box->beginBody(); ?>
                        <?= ContactGridView::detailView([
                            'model'   => $model,
                            'columns' => [
                                'first_name',
                                'last_name',
                                'street',
                                'city',
                                'province',
                                'postal_code',
                                'country',
                            ],
                        ]) ?>
                    <?php $box->endBody(); ?>
                <?php $box::end(); ?>
            </div>
        </div>
    </div>
</div>
