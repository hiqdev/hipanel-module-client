<?php
declare(strict_types=1);

namespace hipanel\modules\client\widgets;

use hipanel\base\CrudController;
use hipanel\modules\client\models\BankDetails;
use hipanel\modules\client\models\Contact;
use hipanel\modules\finance\models\Requisite;
use yii\base\Widget;
use yii\widgets\ActiveForm;

class BankDetailsFormWidget extends Widget
{
    public Requisite|Contact $parentModel;
    public ActiveForm $form;
    public CrudController $controller;

    public function run()
    {
        $currencies = array_keys($this->controller->getCurrencyTypes());
        $isParentModelNew = $this->parentModel->isNewRecord;
        $models = $this->parentModel->isNewRecord || empty($this->parentModel->bankDetails) ? [new BankDetails()] : $this->parentModel->bankDetails;

        return $this->render('BankDetailsForm', [
            'form' => $this->form,
            'models' => $models,
            'parentModel' => $this->parentModel,
            'currencies' => array_combine($currencies, array_map('mb_strtoupper', $currencies)),
        ]);

    }
}
