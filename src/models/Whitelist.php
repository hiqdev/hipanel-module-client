<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\modules\client\models\query\WhitelistQuery;

class Whitelist extends Blacklist
{
    /**
     * {@inheritdoc}
     * @return WhitelistQuery
     */
    public static function find($options = [])
    {
        return new WhitelistQuery(static::class, [
            'options' => $options,
        ]);
    }
}