<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\base\SearchModelTrait;
use yii\helpers\ArrayHelper;

class BlacklistSearch extends Blacklist
{
    use SearchModelTrait {
        SearchModelTrait::searchAttributes as defaultSearchAttributes;
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