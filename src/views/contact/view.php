<?php

use hipanel\helpers\Url;
use hipanel\modules\client\grid\ContactGridView;
use hipanel\widgets\Box;
use hipanel\widgets\ClientSellerLink;
use hiqdev\assets\flagiconcss\FlagIconCssAsset;
use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * @var \hipanel\modules\client\models\Contact $model
 */
$this->title    = Inflector::titleize($model->name, true);
$this->subtitle = Yii::t('hipanel/client', 'Contact detailed information') . ' #' . $model->id;
$this->breadcrumbs->setItems([
    ['label' => Yii::t('hipanel/client', 'Contacts'), 'url' => ['index']],
    $this->title,
]);

FlagIconCssAsset::register($this);

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
            <span class="profile-user-role"><?= $this->title ?></span>
            <br>
            <span class="profile-user-name"><?= ClientSellerLink::widget(compact('model')) ?></span>
        </p>

        <div class="profile-usermenu">
            <ul class="nav">
                <li>
                    <?= Html::a('<i class="fa fa-edit"></i>' . Yii::t('hipanel/client', 'Change contact information'), ['update', 'id' => $model->id]) ?>
                </li>
                <li>
                    <?= Html::a('<i class="fa fa-paperclip"></i>' . Yii::t('hipanel/client', 'Documents'), ['attach-files', 'id' => $model->id]) ?>
                </li>
            <?php if (Yii::getAlias('@domain', false) && $model->used_count > 0) : ?>
                <li>
                    <?= Html::a('<i class="fa fa-globe"></i>' . Yii::t('hipanel/client', 'Used for {n, plural, one{# domain} other{# domains}}', ['n' => $model->used_count]), Url::toSearch('domain', ['client_id' => $model->client_id])) ?>
                </li>
            <?php endif ?>
            </ul>
        </div>
        <?php Box::end() ?>
    </div>

    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                        <?= $box->renderTitle(Yii::t('hipanel/client', 'Contact information')) ?>
                        <?php $box->beginTools() ?>
                            <?= Html::a(Yii::t('hipanel/client', 'Change contact information'), ['update', 'id' => $model->id], ['class' => 'btn btn-default btn-xs']) ?>
                        <?php $box->endTools() ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'seller_id',
                                'client_id',
                                ['attribute' => 'name'],
                                'birth_date',
                                'email_with_verification', 'abuse_email',
                                'voice_phone', 'fax_phone',
                                'messengers', 'other',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>

                <?php if (Yii::$app->user->can('manage')) : ?>
                    <?php $box = Box::begin(['renderBody' => false]) ?>
                        <?php $box->beginHeader() ?>
                            <?= $box->renderTitle(Yii::t('hipanel/client', 'Verification status')) ?>
                        <?php $box->endHeader() ?>
                        <?php $box->beginBody() ?>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <tr>
                                        <th><?= Yii::t('hipanel/client', 'Name') ?></th>
                                        <td>
                                            <?= \hipanel\modules\client\widgets\Confirmation::widget([
                                                'model' => $model->getVerification('name'),
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('hipanel/client', 'Address') ?></th>
                                        <td>
                                            <?= \hipanel\modules\client\widgets\Confirmation::widget([
                                                'model' => $model->getVerification('address'),
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('hipanel/client', 'Email') ?></th>
                                        <td>
                                            <?= \hipanel\modules\client\widgets\Confirmation::widget([
                                                'model' => $model->getVerification('email'),
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('hipanel/client', 'Voice phone') ?></th>
                                        <td>
                                            <?= \hipanel\modules\client\widgets\Confirmation::widget([
                                                'model' => $model->getVerification('voice_phone'),
                                            ]) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?= Yii::t('hipanel/client', 'Fax phone') ?></th>
                                        <td>
                                            <?= \hipanel\modules\client\widgets\Confirmation::widget([
                                                'model' => $model->getVerification('fax_phone'),
                                            ]) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php $box->endBody() ?>
                    <?php $box->end() ?>
                <?php endif ?>
            </div>
            <div class="col-md-6">
                <?php $box = Box::begin(['renderBody' => false]) ?>
                    <?php $box->beginHeader() ?>
                        <?= $box->renderTitle(Yii::t('hipanel/client', 'Postal information')) ?>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'first_name', 'last_name',
                                'organization',
                                'street', 'city', 'province', 'postal_code', 'country',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>


                <?php $box = Box::begin(['renderBody' => false, 'options' => [
                    'class' => 'collapsed-box',
                ]]) ?>
                    <?php $box->beginHeader() ?>
                        <?= $box->renderTitle(Yii::t('hipanel/client', 'Additional information')) ?>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    <?php $box->endHeader() ?>
                    <?php $box->beginBody() ?>
                        <?= ContactGridView::detailView([
                            'boxed'   => false,
                            'model'   => $model,
                            'columns' => [
                                'passport_date', 'passport_no', 'passport_by',
                                'organization_ru', 'inn', 'kpp', 'director_name', 'isresident',
                            ],
                        ]) ?>
                    <?php $box->endBody() ?>
                <?php $box->end() ?>
            </div>
        </div>
    </div>
</div>
