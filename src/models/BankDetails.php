<?php
declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use Yii;

class BankDetails extends Model
{
    use ModelTrait;

    public function rules()
    {
        return [
            [['id', 'requisite_id'], 'integer'],
            [
                [
                    'currency',
                    'bank_name',
                    'bank_account',
                    'bank_address',
                    'bank_swift',
                    'bank_correspondent',
                    'bank_correspondent_swift',
                ],
                'string',
            ],
            [
                [
                    'bank_name',
                    'bank_account',
                    'bank_address',
                    'bank_swift',
                    'bank_correspondent',
                    'bank_correspondent_swift',
                ],
                'trim',
            ],
            [['currency', 'bank_name'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'bank_name' => Yii::t('hipanel:client', 'Bank name'),
            'bank_account' => Yii::t('hipanel:client', 'Bank account'),
            'bank_address' => Yii::t('hipanel:client', 'Bank address'),
            'bank_swift' => Yii::t('hipanel:client', 'SWIFT code'),
            'bank_correspondent' => Yii::t('hipanel:client', 'Correspondent bank'),
            'bank_correspondent_swift' => Yii::t('hipanel:client', 'Correspondent bank SWIFT code'),
        ];
    }

    public function getIsNewRecord()
    {
        if (!empty($this->bank_name) || !empty($this->bank_account)) {
            return false;
        }

        return parent::getIsNewRecord();
    }
}
