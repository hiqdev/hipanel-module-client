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

use hipanel\modules\client\helpers\ClientProfitColumns;
use hipanel\modules\stock\helpers\ProfitColumns;
use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class ClientRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $user = Yii::$app->user;
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'Common'),
                'columns' => array_filter([
                    'checkbox',
                    'login',
                    'name_language',
                    $user->can('client.read') ? 'seller_id' : null,
                    $user->can('client.read') ? 'type' : null,
                    'state',
                    $user->can('bill.read') ? 'balance' : null,
                    $user->can('bill.read') ? 'credit' : null,
                ]),
            ],
            'servers' => $user->can('support') ? [
                'label' => Yii::t('hipanel:client', 'Servers'),
                'columns' => [
                    'checkbox',
                    'login',
                    'name_language', 'seller_id',
                    $user->can('client.read') ? 'type' : null,
                    'registered_and_last_update', 'state',
                    'servers',
                    'accounts_count',
                    'balances',
                ],
            ] : null,
            'documents' => $user->can('support')  && $user->can('document.read') ? [
                'label' => Yii::t('hipanel:client', 'Documents'),
                'columns' => [
                    'checkbox', 'login',
                    'seller', 'requisites',
                    'language',
                ],
            ] : null,
            'profit-report' => Yii::$app->user->can('order.read-profits') && class_exists(ProfitColumns::class) ? [
                'label' => Yii::t('hipanel', 'profit report'),
                'columns' => ClientProfitColumns::getColumnNames(['login']),
            ] : null,
        ]);
    }
}
