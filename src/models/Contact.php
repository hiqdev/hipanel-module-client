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
            [['name', 'first_name', 'last_name'], 'string'],
            [['birth_date', 'passport_date'], 'date'],
            [['passport_no', 'passport_by', 'organization', 'password'], 'safe'],
            [['remote'], 'safe'],
            [['email_confirmed'], 'boolean'],
            [['used_count'], 'integer'],
            [['voice_phone', 'fax_phone'], 'match', 'pattern' => '/^[+]?[()0-9 .-]{3,20}$/', 'message' => Yii::t('app', 'This field must contains phone number in international format.')],
            [['first_name', 'last_name', 'email', 'street1', 'city', 'country', 'postal_code', 'postal_code', 'voice_phone'], 'required', 'on' => ['create', 'update']],

            [['pincode'], 'safe', 'on' => ['update']],

            [['isresident'], 'boolean', 'trueValue' => true, 'falseValue' => false],
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
            ], 'safe'],
            [['email_confirmed', 'voice_phone_confirmed', 'fax_phone_confirmed'],   'boolean', 'trueValue' => true, 'falseValue' => false],
            [['name_confirm_level', 'address_confirm_level'],                       'safe'],
            [['voice_phone_confirm_date', 'fax_phone_confirm_date', 'email_confirm_date', 'address_confirm_date'], 'safe'],
            [['name_confirm_date'],                                                 'safe']
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'first_name'      => Yii::t('app', 'First name'),
            'last_name'       => Yii::t('app', 'Last name'),
            'postal_code'     => Yii::t('app', 'Postal code'),
            'create_time'     => Yii::t('app', 'Create time'),
            'update_time'     => Yii::t('app', 'Update time'),
            'passport_no'     => Yii::t('app', 'Passport number'),
            'passport_by'     => Yii::t('app', 'Passport by'),
            'passport_date'   => Yii::t('app', 'Passport date'),
            'birth_date'      => Yii::t('app', 'Birth date'),
            'icq'             => 'ICQ',
            'other_messenger' => Yii::t('app', 'Other messenger'),
            'voice_phone'     => Yii::t('app', 'Phone'),
            'fax_phone'       => Yii::t('app', 'Fax'),
            'country_name'    => Yii::t('app', 'Country'),
            'abuse_email'     => Yii::t('app', 'Abuse email'),
            'isresident'      => Yii::t('app', 'RF resident'),
        ]);
    }
}
