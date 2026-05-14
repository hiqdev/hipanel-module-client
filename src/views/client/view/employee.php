<?php

use hipanel\modules\client\forms\EmployeeForm;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\modules\client\menus\ClientDetailMenu;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\ClientSwitcher;
use hipanel\modules\finance\widgets\FinanceDocumentsBox;
use hipanel\modules\finance\widgets\FinanceDocumentsBox\PursesDocumentsDataSource;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;

/**
 * @var Client $model
 * @var yii\web\View $this
 * @var array $currencies
 * @var array $documentTypes
 */

FlagIconCssAsset::register($this);

$this->registerCss('legend {font-size: 16px;}');

$form = new EmployeeForm($model->contact, $scenario ?? EmployeeForm::DEFAULT_SCENARIO);

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
        <?= $this->render('./../_custom-attributes', ['model' => $model]) ?>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <?php foreach ($form->getContacts() as $language => $contact) : ?>
                <div class="col-md-6">
                    <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                    <?= $box->renderTitle(Html::tag('span',
                            $language,
                            ['class' => 'label label-default']) . ' ' . Yii::t('hipanel:client',
                            'Contact information')) ?>
                    <?php $box->beginTools() ?>
                    <?= Html::a(Yii::t('hipanel', 'Details'),
                        ['@contact/view', 'id' => $contact->id],
                        ['class' => 'btn btn-default btn-xs']) ?>
                    <?= Html::a(Yii::t('hipanel', 'Change'),
                        ['@contact/update-employee', 'id' => $model->id],
                        ['class' => 'btn btn-default btn-xs']) ?>
                    <?php $box->endTools() ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                    <?= ContactGridView::detailView([
                        'boxed' => false,
                        'model' => $contact,
                        'columns' => array_filter([
                            'name_with_verification',
                            'email',
                            'voice_phone',
                            'fax_phone',
                            'street',
                            'city',
                            'province',
                            'postal_code',
                            (Yii::getAlias("@kyc", false) !== false ? 'kyc_status' : null),
                            'country',
                            'tin_number',
                            'bank_account',
                            'bank_name',
                            'bank_address',
                            'bank_swift',
                        ]),
                    ]) ?>
                    <?php $box->endBody() ?>
                    <?php $box->end() ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?= FinanceDocumentsBox::widget(['dataSource' => new PursesDocumentsDataSource(purses: $model->sortedPurses, client: $model, currencies: $currencies, documentTypes: $documentTypes)]) ?>
            </div>
        </div>
    </div>
</div>
