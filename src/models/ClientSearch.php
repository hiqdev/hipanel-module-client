<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use hipanel\base\SearchModelTrait;
use hipanel\helpers\ArrayHelper;
use Yii;

class ClientSearch extends Client
{
    const DEBT_LABEL_CREDITOR = 'creditor';
    const DEBT_LABEL_DEBTOR = 'debtor';
    const DEBT_LABEL_NEUTRAL = 'neutral';

    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public static function tableName()
    {
        return Client::tableName();
    }

    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'login_email_in',
            'created_from',
            'created_till',
            'hide_deleted',
            'types',
            'states',
            'login_email_like',
            'profit_time_from',
            'profit_time_till',
            'profit_not_empty',
            'hide_internal',
            'debt_type',
            'total_balance_gt',
            'total_balance_lt',
            'total_balance',
            'balance_gt',
            'balance_lt',
            'only_with_note',
            'tags',
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'login_email_like' => Yii::t('hipanel:client', 'Login or Email'),
            'login_email_in' => Yii::t('hipanel:client', 'Logins or E-Mails'),
            'profit_not_empty' => Yii::t('hipanel:client', 'Show not empty'),
            'client_id' => Yii::t('hipanel:client', 'Client'),
            'hide_internal' => Yii::t('hipanel:client', 'Hide system'),
            'debt_type' => Yii::t('hipanel:client', 'Financial type'),
            'only_with_note' => Yii::t('hipanel:client', 'Only with note'),
        ]);
    }

    public static function getDebtLabels(): array
    {
        return [
            self::DEBT_LABEL_DEBTOR => Yii::t('hipanel:client', 'Debtor'),
            self::DEBT_LABEL_CREDITOR => Yii::t('hipanel:client', 'Creditor'),
            self::DEBT_LABEL_NEUTRAL => Yii::t('hipanel:client', 'Neutral'),
        ];
    }
}
