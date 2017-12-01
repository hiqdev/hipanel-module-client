<?php

namespace hipanel\modules\client\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class ClientRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'Common'),
                'columns' => [
                    'checkbox',
                    'login',
                    'name_language', 'seller_id',
                    'type', 'state',
                    'balance', 'credit',
                ],
            ],
            'servers' => Yii::$app->user->can('support') ? [
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
            'payment' => Yii::$app->user->can('support') ? [
                'label' => Yii::t('hipanel:client', 'Payment'),
                'columns' => [
                    'checkbox', 'login', 'seller_id',
                    'balance',
                    'balances',
                    'last_deposit',
                    'payment_ticket',
                    'requisites',
                    'credit',
                    'language',
                ],
            ] : null,
            'documents' => Yii::$app->user->can('support') ? [
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
