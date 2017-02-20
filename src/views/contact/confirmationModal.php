<?php

use hipanel\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var \yii\web\View
 * @var \hipanel\modules\client\models\Contact $contact
 * @var \hipanel\modules\client\forms\PhoneConfirmationForm $model
 * @var \hipanel\modules\client\models\NotifyTries $tries
 */
?>

<?php $form = ActiveForm::begin([
    'action' => ['@contact/confirm-phone', 'id' => $model->id, 'type' => $model->type],
    'options' => [
        'id' => 'confirmation-form',
    ],
]) ?>

    <div class="alert" role="alert">
        <?= Yii::t('hipanel:client', 'Phone confirmation is a simple procedure that helps us to verify your identity. Press the "Request code" button bellow to get SMS message with confirmation code. Enter the code from a message and press "Confirm" button to complete the phone confirmation procedure.') ?>
    </div>

<?= Html::activeHiddenInput($model, 'id', ['class' => 'confirmation-form-id']) ?>
<?= Html::activeHiddenInput($model, 'type') ?>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'phone')->textInput(['readonly' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'code') ?></div>
    </div>

<?php if (!$tries->isIntervalSatisfied()) : ?>
    <p class="docs-next-try">
        <?= Yii::t('hipanel:client', 'We have sent the confirmation code on your phone number.') ?>

        <?= Yii::t('hipanel:client',
            'Usually we deliver SMS immediately, but sometimes it takes a bit longer. In case you have not received the code, you can request a new one {time}',
            [
                'time' => Html::tag('span', '', ['data-seconds' => $tries->sleep]),
            ]) ?>
    </p>
<?php endif ?>

    <hr>

<?= Html::submitButton(Yii::t('hipanel', 'Confirm'), [
    'class' => 'btn btn-success',
    'data' => [
        'loading-text' => Yii::t('hipanel:client', 'Checking...'),
    ],
]) ?>

<?= Html::button(Yii::t('hipanel:client', 'Request code'), [
    'id' => 'request-code',
    'class' => 'pull-right btn btn-info ' . (!$tries->isIntervalSatisfied() ? 'hide' : ''),
    'data' => [
        'url' => Url::to(['@contact/request-phone-confirmation-code']),
        'loading-text' => Yii::t('hipanel:client', 'Requesting...'),
    ],
]) ?>

<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>

<?php $form->end() ?>


<?php $this->registerJs(<<<JS
(function () {
    var requestButton = $('#request-code');
    var form = $('#confirmation-form');
    var nextTryBlock = $('.docs-next-try');
    
    // Init attributes
    requestButton.filter('.hide').attr('disabled', true);
    
    var enableRequestButton = function () {
        return requestButton.removeClass('hide').removeAttr('disabled')
    };
    
    requestButton.on('click', function (event) {
        event.preventDefault();
        if ($(this).hasClass('disabled')) {
            return false;
        }

        $.post({
            url: $(this).data('url'),
            data: form.serialize(),
            beforeSend: function () {
                $(this).button('loading');
            }.bind(this),
            success: function (response) {
                if (response.success) {
                    return form.trigger('reload');
                }
                
                hipanel.notify.error(response.error);
                $(this).button('reset');
            }
        });
    });
    
    form.on('reload', function () {
        var modalBody = form.parent();
        $.get({
            url: modalBody.data('action-url'),
            beforeSend: function () {
                modalBody.html(hipanel.loadingBar());
            },
            success: function (html) {
                modalBody.html(html);
            }
        });
    });
    
    form.on('beforeSubmit', function (event) {
        event.preventDefault();
        var submitButton = $(this).find('button[type="submit"]');
        
        $.post({
            url: $(this).attr('action'),
            data: form.serialize(),
            beforeSend: function () {
                submitButton.button('loading');
            }.bind(this),
            success: function (response) {
                if (response.success) {
                    hipanel.notify.success(response.success);
                    location.reload();
                    return;
                }
                
                hipanel.notify.error(response.error);
                submitButton.button('reset');
            }
        });
        
        return false;
    });
    
    if (nextTryBlock.length) {
        var nextTry = nextTryBlock.find('span');
        var nextTryMoment = moment().add(nextTry.data('seconds'), 'second');
        var updateNextTry = function () {
            if (nextTryMoment.diff(moment()) > 0) {
                nextTry.text(nextTryMoment.fromNow());
            } else {
                nextTry.text('');
                enableRequestButton();
                clearInterval(intervalId);
            }
        };
        updateNextTry();
        var intervalId = setInterval(updateNextTry, 1000);
    }
})();

JS
);
