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
                    'description',
                    $user->can('bill.read') ? 'balance' : null,
                    $user->can('bill.read') ? 'credit' : null,
                    $user->can('client.read') ? 'seller_id' : null,
                    $user->can('client.read') ? 'type' : null,
                    'state',
                ]),
            ],
            'servers' =>  [
                'visible' => $user->can('client.read-financial-info'),
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
            ],
            'documents' => [
                'visible' => $user->can('client.read-requisite') && $user->can('document.read'),
                'label' => Yii::t('hipanel:client', 'Documents'),
                'columns' => [
                    'checkbox', 'login',
                    'seller', 'requisites',
                    'language',
                ],
            ],
            'profit-report' => class_exists(ProfitColumns::class) ? [
                'visible' => Yii::$app->user->can('order.read-profits'),
                'label' => Yii::t('hipanel', 'profit report'),
                'columns' => ClientProfitColumns::getColumnNames(['login']),
            ] : null,
            'referral' => [
                'visible' => Yii::$app->user->can('client.read-referral'),
                'label' => Yii::t('hipanel', 'Referral'),
                'columns' => array_filter([
                    'checkbox',
                    'login_without_note',
                    'seller_id',
                    'referer_id',
                    'referrals',
                    'earnings',
                    'referral_tariff',
                    'state',
                    'balance',
                ]),
            ],
        ]);
    }
}
