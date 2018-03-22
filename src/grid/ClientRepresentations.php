<?php

namespace hipanel\modules\client\grid;

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
                    'name_language', 'seller_id',
                    'type', 'state',
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
                    'type', 'registered_and_last_update', 'state',
                    'servers',
                    'accounts_count',
                    'balances',
                ],
            ] : null,
            'payment' => $user->can('support') && $user->can('bill.read') ? [
                'label' => Yii::t('hipanel:client', 'Payment'),
                'columns' => [
                    'checkbox', 'login_without_note', 'note',
                    'sold_services',
                    'balance',
                    'last_deposit',
                    'debt_period',
                    'payment_ticket',
                    'lang',
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
        ]);
    }
}
