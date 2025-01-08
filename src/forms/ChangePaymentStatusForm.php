<?php declare(strict_types=1);

namespace hipanel\modules\client\forms;

use hipanel\modules\client\models\Client;

class ChangePaymentStatusForm extends Client
{
    public bool $deny_deposit = true;

    public static function tableName(): string
    {
        return 'client';
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['deny_deposit'], 'boolean', 'on' => 'change-payment-status'],
            [['id', 'deny_deposit'], 'required', 'on' => 'change-payment-status'],
        ]);
    }
}
