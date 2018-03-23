<?php

namespace hipanel\modules\client\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class ContactRepresentations extends RepresentationCollection
{
    protected function fillRepresentations()
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'Common'),
                'columns' => array_filter([
                    'checkbox',
                    'name', 'actions', 'email',
                    'client_like',
                    Yii::$app->user->can('client.read') ? 'seller_id' : null,
                ]),
            ],
            'requisites' => [
                'label' => Yii::t('hipanel:client', 'Requisites'),
                'columns' => [
                    'checkbox',
                    'name', 'actions', 'requisites',
                ],
            ],
        ]);
    }
}
