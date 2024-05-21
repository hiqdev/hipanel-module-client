<?php declare(strict_types=1);

namespace hipanel\modules\client\grid;

use hiqdev\higrid\representations\RepresentationCollection;
use Yii;

class BlacklistRepresentations extends RepresentationCollection
{
    protected function fillRepresentations(): void
    {
        $this->representations = array_filter([
            'common' => [
                'label' => Yii::t('hipanel', 'Common'),
                'columns' => array_filter([
                    'checkbox',
                    'name', 'actions',
                    Yii::$app->user->can('blacklist.read') ? 'seller_id' : null,
                ]),
            ],
        ]);
    }
}