<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use Yii;
use yii\base\Model;

class Verification extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    /**
     * @var Contact
     */
    public $contact;

    const LEVEL_UNCONFIRMED = 'unconfirmed';
    const LEVEL_CONFIRMED = 'confirmed';
    const LEVEL_VERIFIED = 'fullverified';

    /**
     * @var array types that have multiple confirmation levels
     */
    private $multilevelTypes = ['name', 'address'];

    public static function tableName()
    {
        return Contact::tableName();
    }

    /**
     * Creates this Verification model from the existing $model for the $attribute
     * @param Model $model
     * @param $attribute
     * @return static
     */
    public static function fromModel(Model $model, $attribute)
    {
        $valueAttribute = $attribute . '_confirmed';
        $levelAttribute = $attribute . '_confirm_level';
        $dateAttribute = $attribute . '_confirm_date';

        $modelValue = $model->$attribute;
        $value = isset($model->$valueAttribute) ? $model->$valueAttribute : null;
        $level = isset($model->$levelAttribute) ? $model->$levelAttribute : null;
        $date = isset($model->$dateAttribute) ? $model->$dateAttribute : null;

        $options = [
            'id' => $model->id,
            'type' => $attribute,
            'contact' => $model,
        ];

        if (isset($date)) {
            $options['date'] = $date;
        }

        // TODO: get rid of this crutch. Move into VerificationValueNormalizer or so
        if (in_array($attribute, ['voice_phone', 'fax_phone']) && !empty($value)) {
            $value = preg_replace('/[^0-9]/', '', $value);
            $modelValue = preg_replace('/[^0-9]/', '', $modelValue);
        }

        if (isset($level)) {
            $options['level'] = $level;
        } elseif (isset($value) && $value === $modelValue) {
            $options['level'] = static::LEVEL_CONFIRMED;
        } else {
            $options['level'] = static::LEVEL_UNCONFIRMED;
        }

        return new static($options);
    }

    public function init()
    {
        if ($this->level === null) {
            $this->level = static::LEVEL_UNCONFIRMED;
        }
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['!date'], 'date'],
            [['level'], 'in', 'range' => array_keys($this->getLevels()), 'on' => ['default', 'set-confirmation']],
            [['type'], 'in', 'range' => $this->getTypes(), 'on' => ['default', 'set-confirmation']],

            [['id', 'type'], 'required', 'on' => ['set-confirmation']],
        ];
    }

    public function getLevels()
    {
        $out = [];
        foreach ([static::LEVEL_CONFIRMED, static::LEVEL_VERIFIED, static::LEVEL_UNCONFIRMED] as $level) {
            $out[$level] = ['value' => $level, 'text' => $this->getLabels()[$level]];
        }

        return $out;
    }

    public function getLabels()
    {
        return [
            static::LEVEL_UNCONFIRMED => Yii::t('hipanel:client', 'Not confirmed'),
            static::LEVEL_CONFIRMED => Yii::t('hipanel:client', 'Confirmed'),
            static::LEVEL_VERIFIED => Yii::t('hipanel:client', 'Verified'),
        ];
    }

    public function isVerified()
    {
        return $this->level === static::LEVEL_VERIFIED;
    }

    public function isConfirmed()
    {
        return $this->level === static::LEVEL_CONFIRMED || $this->level === static::LEVEL_VERIFIED;
    }

    public function getAvailableLevels()
    {
        $result = $this->getLevels();

        if (!$this->typeIsMultilevel()) {
            unset($result[static::LEVEL_VERIFIED]);
        }

        return array_values($result);
    }

    protected function typeIsMultilevel()
    {
        return in_array($this->type, $this->multilevelTypes, true);
    }

    public function getTypes()
    {
        return [
            'name',
            'address',
            'email',
            'voice_phone',
            'fax_phone',
        ];
    }
}
