<?php

namespace hipanel\modules\client\widgets;

use hipanel\modules\client\models\Contact;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Class GdprConsent
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class GdprConsent extends Widget
{
    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var Contact
     */
    public $model;

    public function run()
    {
        if ($this->model->gdpr_agreement && $this->model->privacy_policy) {
            return $this->renderHiddenInputs();
        }

        $this->registerClientScript();
        return $this->render('gdpr-consent', [
            'form' => $this->form,
            'model' => $this->model,
        ]);
    }

    public function registerClientScript()
    {
        $this->view->registerJs(<<<JS
(function () {
    var modal = $('#gdpr-consent-modal'),
        form = modal.closest('form'),
        acceptingButton = $('.gdpr-acception');
    
    var validToCloseModal = {
        privacy_policy: false,
        gdpr_agreement: false
    };
    var isGdprAccepted = function () {
        var gdprIsAccepted = true;
        for (var attr in validToCloseModal) {
            gdprIsAccepted = gdprIsAccepted && validToCloseModal[attr];
        }
        return gdprIsAccepted;
    }
    form.on('afterValidateAttribute', function (event, attribute, error) {
        if (validToCloseModal[attribute.name] === undefined) {
            return;
        }
        validToCloseModal[attribute.name] = error.length === 0;
        if (isGdprAccepted() && acceptingButton.data('clicked')) {
            modal.modal('hide');
        }
    });
    
    acceptingButton.click(function (event) {
        $(this).data('clicked', true);
        if (isGdprAccepted()) {
            modal.modal('hide');
        } else {
            form.yiiActiveForm('validate', true);
        }
    });
    
    modal.modal('show');
})()
JS
        );
    }

    private function renderHiddenInputs()
    {
        return implode('', [
            Html::activeHiddenInput($this->model, 'gdpr_agreement'),
            Html::activeHiddenInput($this->model, 'privacy_policy'),
        ]);
    }
}
