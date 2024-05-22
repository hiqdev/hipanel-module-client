<?php declare(strict_types=1);

namespace hipanel\modules\client\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class BlacklistRepresentations extends RepresentationCollection
{
    protected function fillRepresentations(): void
    {
        $user = Yii::$app->user;
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'Common'),
                'columns' => array_filter([
                    'checkbox',
                    'name',
                    $user->can('client.read') ? 'type' : null,
                    'message',
                    'show_message',
                    'client_like',
                    //'state',
                    'create_time',
                ]),
            ],
        ]);
    }
}