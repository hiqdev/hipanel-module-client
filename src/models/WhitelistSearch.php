<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\base\SearchModelTrait;
use hipanel\modules\client\models\query\WhitelistQuery;
use yii\helpers\ArrayHelper;

class WhitelistSearch extends Whitelist
{
    use SearchModelTrait {
        SearchModelTrait::searchAttributes as defaultSearchAttributes;
    }

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

    public function searchAttributes(): array
    {
        return ArrayHelper::merge($this->defaultSearchAttributes(), [
            'category',
            'states',
            'types',
            'name_ilike',
            'limit',
        ]);
    }
}