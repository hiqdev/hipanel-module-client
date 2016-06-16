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

class Confirmation extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const LEVEL_UNCONFIRMED = 'unconfirmed';
    const LEVEL_CONFIRMED = 'confirmed';
    const LEVEL_VERIFIED = 'fullverified';

    /**
     * @var array types that have multiple confirmation levels
     */
    private $multilevelTypes = ['name', 'address'];

    public static function index()
    {
        return Contact::index();
    }

    public static function type()
    {
        return Contact::type();
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
        return [
            static::LEVEL_UNCONFIRMED => ['value' => static::LEVEL_UNCONFIRMED, 'text' => Yii::t('hipanel/client', 'Not confirmed')],
            static::LEVEL_CONFIRMED => ['value' => static::LEVEL_CONFIRMED, 'text' => Yii::t('hipanel/client', 'Confirmed')],
            static::LEVEL_VERIFIED => ['value' => static::LEVEL_VERIFIED, 'text' => Yii::t('hipanel/client', 'Verified')]
        ];
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
            'fax_phone'
        ];
    }
}
