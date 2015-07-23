<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use Yii;

class Contact extends \hipanel\base\Model
{
    /*
     * @return array the list of attributes for this record
     */

    use \hipanel\base\ModelTrait;

    public function rules()
    {
        return [
            [['id', 'obj_id', 'client_id', 'seller_id'], 'safe'],
            [['type_id', 'state_id'], 'safe'],
            [['client_name'], 'safe'],
            [['create_time', 'update_time', 'created_date', 'updated_date'], 'safe'],
            [['client', 'seller', 'state', 'type'], 'safe'],
            [['email', 'abuse_email'], 'email'],
            [['country', 'country_name', 'province', 'province_name'], 'safe'],
            [['postal_code'], 'safe'],
            [['city', 'street1', 'street2', 'street3'], 'safe'],
            [['voice_phone', 'fax_phone'], 'safe'],
            [['icq', 'skype', 'jabber'], 'safe'],
            [['roid', 'epp_id', 'remoteid', 'other_messenger'], 'safe'],
            [['name', 'first_name', 'last_name', 'voice_phone_extension'], 'safe'],
            [['birth_date', 'passport_date'], 'date'],
            [['passport_no', 'passport_by', 'organization', 'password'], 'safe'],
            [['remote'], 'safe'],
            [['email_confirmed'], 'boolean'],

            [['first_name', 'last_name', 'email', 'street1', 'city', 'country', 'postal_code', 'postal_code', 'voice_phone'], 'required', 'on' => ['create', 'update']],

            [[
                // Для регистрации доменов в зоне RU в качестве физического лица
                'birth_date',
                'passport_no',
                'passport_date',
                'passport_by',

                // Для регистрации доменов в зоне RU в качестве юридического лица
                'organization_ru',
                'director_name',
                'inn',
                'kpp',
                'isresident',
            ], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'create_time' => Yii::t('app', 'Create time'),
            'update_time' => Yii::t('app', 'Update time'),
            'passport_no' => Yii::t('app', 'Passport number'),
            'passport_by' => Yii::t('app', 'Passport by'),
            'passport_date' => Yii::t('app', 'Passport date'),
            'icq' => 'ICQ',
            'voice_phone' => Yii::t('app', 'Phone'),
            'fax_phone' => Yii::t('app', 'Fax'),
            'country_name' => Yii::t('app', 'Country'),
            'abuse_email' => Yii::t('app', 'Abuse email'),
        ]);
    }
}
