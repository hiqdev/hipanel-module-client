<?php

use hipanel\helpers\Url;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\widgets\combo\ClientCombo;
use hipanel\modules\client\widgets\combo\SellerCombo;
use hiqdev\combo\StaticCombo;
use hipanel\widgets\DynamicFormWidget;
use hipanel\widgets\PasswordInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'id' => 'client-form',
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->isNewRecord ? 'create' : 'update']),
]);
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 99, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $model,
    'formId' => 'client-form',
    'formFields' => [
        'login',
        'email',
        'password',
        'type',
        'seller_id',
        'currencies',
    ],
]) ?>

<div class="container-items">
    <?php foreach ($models as $i => $model) : ?>
        <div class="item">
            <?php if (!$model->isNewRecord && (!$model->notMyself() || !$model->notMySeller())): ?>
                <div class="box box-widget">
                    <h3 class="box-title"><?= Yii::t('hipanel', '403 Error') ?></h3>
                    <div class="box-body">
                        <div class="row text-danger">
                            <div class="col-md-12">
                                <?= Yii::t('hipanel:client', 'You could not edit your account. Operation is not permitted') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <?php continue ?>
            <?php endif ?>
            <div class="box box-widget">
                <div class="box-header with-border">
                    <?php if ($model->isNewRecord) : ?>
                        <h3 class="box-title"></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool remove-item"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool add-item"><i class="fa fa-plus"></i></button>
                        </div>
                    <?php else: ?>
                        <h3 class="box-title"><?= $model->login ?></h3>
                    <?php endif; ?>
                </div>
                <div class="box-body">
                    <div class="row">
                        <?php if ($model->isNewRecord) : ?>
                            <div class="col-md-2">
                                <?= $form->field($model, "[{$i}]login")->textInput(['autocomplete' => 'new-login']) ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, "[{$i}]email")->textInput(['autocomplete' => 'new-email']) ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, "[{$i}]password")->widget(PasswordInput::class) ?>
                            </div>
                        <?php else: ?>
                            <?= $form->field($model, "[{$i}]id")->hiddenInput()->label(false) ?>
                        <?php endif; ?>
                        <div class="col-md-1">
                            <?= $form->field($model, "[{$i}]type")->dropDownList(Client::getTypeOptions()) ?>
                        </div>
                        <?php if (Yii::$app->user->can('client.create') || Yii::$app->user->can('client.update')) : ?>
                            <div class="col-md-2">
                                <?= $form->field($model, "[{$i}]referer_id")->widget(ClientCombo::class) ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, "[{$i}]seller_id")->widget(SellerCombo::class, [
                                    'clientType' => ['owner', 'reseller', 'client'],
                                    'pluginOptions' => [
                                        'select2Options' => $model->isNewRecord ? [] : [
                                            'templateSelection' => new \yii\web\JsExpression("
                                                function (data, container) {
                                                    var disVal = '{$model->seller}';
                                                    if ( container ) {
                                                        return data.text;
                                                    } else {
                                                        $('#client-{$i}-seller_id').attr('disabled', true);
                                                        return disVal;
                                                    }
                                                }
                                            "),
                                        ],
                                    ],
                                ]) ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <?php if (Yii::$app->user->can('purse.update') && $model->canBeAccountOwner()): ?>
                        <div class="row">
                            <?= $form->field($model, "[{$i}]currencies")->widget(StaticCombo::class, [
                                'multiple' => true,
                                'data' => $currencies,
                            ]) ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php DynamicFormWidget::end(); ?>

<?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
&nbsp;
<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php $form->end() ?>
