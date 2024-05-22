<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\base\SearchModelTrait;

class BlacklistSearch extends Blacklist
{
    use SearchModelTrait {
        searchAttributes as defaultSearchAttributes;
    }

    public function rules(): array
    {
        return [
            [['obj_id', 'type_id', 'state_id', 'client_id', 'object_id'], 'integer'],
            [['name', 'message', 'last_notified'], 'safe'],
            [['show_message'], 'boolean'],
            [['name', 'message', 'state', 'type', 'client'], 'string'],
        ];
    }

    public function searchAttributes(): array
    {
        return \yii\helpers\ArrayHelper::merge($this->defaultSearchAttributes(), [
            'states',
            'types',
            'limit',
            'tags',
        ]);
    }
}