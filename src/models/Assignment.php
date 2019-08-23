<?php

namespace hipanel\modules\client\models;

use hipanel\base\ModelTrait;
use hiqdev\hiart\ActiveRecord;

/**
 * Class Assignment.
 *
 * @property string $type
 * @property string[]|int[] $tariff_ids
 * @property string[]|int[] $profile_ids
 * @property int $seller_id
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class Assignment extends ActiveRecord
{
    use ModelTrait;

    public const TYPE_TARIFF = 'tariff';

    public static function tableName()
    {
        return 'profile';
    }

    public function rules()
    {
        return [
            [['tariff_ids', 'profile_ids', 'type', 'tariff_names'], 'safe'],
            [['seller_id'], 'int'],
        ];
    }

    /**
     * @return bool Whether the assignment was inherited from the seller's defaults
     */
    public function isInherited(): bool
    {
        return empty($this->tariff_ids) && $this->profile_ids === [$this->seller_id];
    }
}
