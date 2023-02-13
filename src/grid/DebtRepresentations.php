<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class DebtRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'Common'),
                'columns' => [
                    'checkbox', 'login_without_note', 'description', 'seller',
                    'sold_services',
                    'total_balance',
                    'last_deposit',
                    'debt_depth',
                    'payment_ticket',
                    'lang',
                ],
            ],
            'advanced' => [
                'label' => Yii::t('hipanel', 'Advanced'),
                'columns' => [
                    'checkbox', 'login_without_note', 'description', 'seller',
                    'sold_services',
                    'total_balance',
                    'balance_usd',
                    'balance_eur',
                    'balance_rub',
                    'balance_pln',
                    'balance_sgd',
                    'balance_gbp',
                    'balance_jpy',
                    'balance_hkd',
                    'balance_btc',
                    'last_deposit',
                    'debt_depth',
                    'payment_ticket',
                    'payment_status',
                    'ticket_status',
                    'lang',
                ],
            ],
        ]);
    }
}
