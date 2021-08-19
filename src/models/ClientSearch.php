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
    const DEBT_LABEL_DEBITOR = 'debitor';

    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public function searchAttributes()
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'created_from', 'created_till',
            'types', 'states', 'login_email_like',
            'profit_time_from', 'profit_time_till',
            'profit_not_empty', 'hide_system',
            'debt_type',
            'full_balance_gt', 'full_balance_lt',
            'balance_gt', 'balance_lt',
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'login_email_like' => Yii::t('hipanel:client', 'Login or Email'),
            'profit_not_empty' => Yii::t('hipanel:client', 'Show not empty'),
            'client_id' => Yii::t('hipanel:client', 'Client'),
            'hide_system' => Yii::t('hipanel:client', 'Hide system'),
            'debt_type' => Yii::t('hipanel:client', 'Financial type'),
        ]);
    }

    public static function getDebtLabels(): array
    {
        return [
            self::DEBT_LABEL_DEBITOR => Yii::t('hipanel:client', 'Debitor'),
            self::DEBT_LABEL_CREDITOR => Yii::t('hipanel:client', 'Creditor'),
        ];
    }
}
