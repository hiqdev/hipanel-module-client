<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\base\SearchModelTrait;
use yii\helpers\ArrayHelper;

class BlacklistSearch extends Blacklist
{
    use SearchModelTrait {
        SearchModelTrait::searchAttributes as defaultSearchAttributes;
    }

    public function rules(): array
    {
        return [
            [['obj_id', 'type_id', 'state_id', 'client_id', 'object_id'], 'integer'],
            [['name', 'message', 'state', 'type', 'client', 'types', 'states'], 'string'],
            [['show_message'], 'boolean'],

            [['category', 'name_ilike'], 'safe'],
        ];
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