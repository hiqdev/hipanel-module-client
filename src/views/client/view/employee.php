<?php

use hipanel\modules\client\grid\ClientGridView;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\menus\ClientDetailMenu;
use hipanel\modules\client\models\Client;
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

$form = new \hipanel\modules\client\forms\EmployeeForm($model->contact, $scenario);

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
            <?= ClientDetailMenu::widget([
                'model' => $model,
            ]) ?>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php foreach ($form->getContacts() as $language => $contact) : ?>
                <div class="col-md-6">
                    <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Html::tag('span', $language, ['class' => 'label label-default']) . ' ' . Yii::t('hipanel:client', 'Contact information')) ?>
                    <?php $box->beginTools() ?>
                    <?= Html::a(Yii::t('hipanel', 'Details'), ['@contact/view', 'id' => $contact->id], ['class' => 'btn btn-default btn-xs']) ?>
                    <?= Html::a(Yii::t('hipanel', 'Change'), ['@contact/update-employee', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                    <?php $box->endTools() ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                    <?= ContactGridView::detailView([
                        'boxed' => false,
                        'model' => $contact,
                        'columns' => [
                            'name_with_verification',
                            'email', 'voice_phone', 'fax_phone',
                            'street', 'city', 'province', 'postal_code', 'country',
                            'tin_number',
                            'bank_account', 'bank_name', 'bank_address', 'bank_swift'
                        ],
                    ]) ?>
                    <?php $box->endBody() ?>
                    <?php $box->end() ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?php foreach ($model->purses as $purse) : ?>
                    <?= $this->render('@hipanel/modules/finance/views/purse/_client-view', ['model' => $purse]) ?>
                <?php endforeach ?>
            </div>
            <div class="col-md-6">
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
                        'models' => $model->contact->documents,
                    ]) ?>
                    <?php $box->endBody() ?>
                    <?php $box->end() ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
