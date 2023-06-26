<?php
declare(strict_types=1);

namespace hipanel\modules\client\widgets;

use hipanel\modules\client\models\BankDetails;
use yii\base\Widget;

class BankDetailsSummaryRenderWidget extends Widget
{
    /** @var BankDetails[] */
    public array $models;

    public function run()
    {
        $result = [];
        foreach ($this->models as $model) {
            $result[] = implode("\n",
                array_filter([
                    $this->renderBankAccount($model),
                    $this->renderBankName($model->bank_name),
                    $this->renderBankAddress($model->bank_address),
                    $this->renderBankSwift($model->bank_swift),
                    $this->renderCorrespondentBank($model->bank_correspondent),
                    $this->renderCorrespondentBankSwift($model->bank_correspondent_swift),
                ]));
        }

        return implode("\n\n", $result);
    }

    private function renderBankAccount(BankDetails $model): ?string
    {
        if (empty($model->bank_account)) {
            return null;
        }
        $currency = '';
//        $currency = mb_strtoupper($model->currency);  // todo: adjust currency display
        $iban = $model->bank_account;

        return !str_contains($iban, "\n") ? "$currency IBAN: $iban" : $currency . " " . $iban;
    }

    private function renderBankName($name): ?string
    {
        return $name ? "Bank Name: $name" : $name;
    }

    private function renderBankAddress(?string $address): ?string
    {
        return $address ? 'Bank Address: ' . $address : $address;
    }

    private function renderBankSwift(?string $swift): ?string
    {
        return $swift ? 'SWIFT code: ' . $swift : $swift;
    }

    private function renderCorrespondentBank(?string $name): ?string
    {
        return $name ? 'Correspondent bank: ' . $name : $name;
    }

    private function renderCorrespondentBankSwift(?string $swift): ?string
    {
        return $swift ? 'Correspondent bank SWIFT: ' . $swift : $swift;
    }

}
