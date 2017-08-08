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
                    'name', 'seller_id',
                    'type', 'state',
                    'balance', 'credit',
                ],
            ],
            'payment' => Yii::$app->user->can('support') ? [
                'label' => Yii::t('hipanel:client', 'Payment'),
                'columns' => [
                    'checkbox', 'login',
                    'balance',
                ],
            ] : null,
            'documents' => Yii::$app->user->can('support') ? [
                'label' => Yii::t('hipanel:client', 'Documents'),
                'columns' => [
                    'checkbox', 'login',
                ],
            ] : null,
        ]);
    }
}
