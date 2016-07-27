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

use hipanel\behaviors\File;
use Yii;

class Contact extends \hipanel\base\Model
{
    /*
     * @return array the list of attributes for this record
     */
    use \hipanel\base\ModelTrait;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => File::class,
                'attribute' => 'file',
                'targetAttribute' => 'file_ids',
                'scenarios' => ['attach-files'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['id', 'obj_id', 'client_id', 'seller_id'], 'integer'],
            [['type_id', 'state_id'], 'integer'],
            [['client_name'], 'safe'],
            [['create_time', 'update_time', 'created_date', 'updated_date'], 'date'],
            [['client', 'seller', 'state', 'type'], 'safe'],
            [['email', 'abuse_email', 'email_new'], 'email'],
            [['country', 'country_name', 'province', 'province_name'], 'safe'],
            [['postal_code'], 'safe'],
            [['city', 'street1', 'street2', 'street3'], 'safe'],
            [['voice_phone', 'fax_phone'], 'safe'],
            [['icq', 'skype', 'jabber'], 'safe'],
            [['roid', 'epp_id', 'remoteid', 'other_messenger'], 'safe'],
            [['name', 'first_name', 'last_name'], 'string'],
            [['birth_date', 'passport_date'], 'safe'],
            [['passport_no', 'passport_by', 'organization', 'password'], 'safe'],
            [['remote', 'file'], 'safe'],
            [['email_confirmed'], 'boolean'],
            [['used_count'], 'integer'],
            [
                ['voice_phone', 'fax_phone'],
                'match',
                'pattern' => '/^[+]?[()0-9 .-]{3,20}$/',
                'message' => Yii::t('hipanel/client', 'This field must contains phone number in international format.')
            ],
            [
                [
                    'first_name',
                    'last_name',
                    'email',
                    'street1',
                    'city',
                    'country',
                    'postal_code',
                    'postal_code',
                    'voice_phone'
                ],
                'required',
                'on' => ['create', 'update']
            ],

            [['pincode'], 'safe', 'on' => ['update']],

            [['isresident'], 'boolean', 'trueValue' => true, 'falseValue' => false],
            [['birth_date', 'passport_date'], 'safe', 'on' => ['update', 'create']],
            [
                [
                    // Для регистрации доменов в зоне RU в качестве физического лица
                    'passport_no',
                    'passport_by',

                    // Для регистрации доменов в зоне RU в качестве юридического лица
                    'organization_ru',
                    'director_name',
                    'inn',
                    'kpp',
                ],
                'safe'
            ],
            [
                ['email_confirmed', 'voice_phone_confirmed', 'fax_phone_confirmed'],
                'boolean',
                'trueValue' => true,
                'falseValue' => false
            ],
            [['name_confirm_level', 'address_confirm_level'], 'safe'],
            [
                ['voice_phone_confirm_date', 'fax_phone_confirm_date', 'email_confirm_date', 'address_confirm_date'],
                'safe'
            ],
            [['name_confirm_date'], 'safe'],

            // Change contact
            [['domainId', 'contactType', 'domainName'], 'safe', 'on' => ['create', 'change-contact']],

            [
                ['id'],
                'required',
                'on' => ['request-email-confirmation', 'request-phone-confirmation', 'attach-files', 'delete', 'update']
            ],
            [['file_ids'], 'safe', 'on' => ['attach-files']],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'passport_no'       => Yii::t('hipanel/client', 'Passport number'),
            'icq'               => 'ICQ',
            'voice_phone'       => Yii::t('hipanel/client', 'Phone'),
            'fax_phone'         => Yii::t('hipanel/client', 'Fax'),
            'country_name'      => Yii::t('hipanel/client', 'Country'),
            'isresident'        => Yii::t('hipanel/client', 'RF resident'),
            'street1'           => Yii::t('hipanel/client', 'Street'),
            'street2'           => Yii::t('hipanel/client', 'Street'),
            'street3'           => Yii::t('hipanel/client', 'Street'),
            'inn'               => Yii::t('hipanel/client', 'Taxpayer identification number'),
            'kpp'               => Yii::t('hipanel/client', 'Code of reason for registration'),
            'organization_ru'   => Yii::t('hipanel/client', 'Organization (Russian title)'),
            'director_name'     => Yii::t('hipanel/client', 'Director\'s full name'),
        ]);
    }

    public function getVerification($type)
    {
        $confirmedValueAttribute = $type . '_confirmed';
        $levelAttribute = $type . '_confirm_level';
        $confirmDateAttribute = $type . '_confirm_date';

        $options = [
            'id' => $this->id,
            'type' => $type,
            'contact' => $this,
        ];

        if (isset($this->$confirmDateAttribute)) {
            $options['date'] = $this->$confirmDateAttribute;
        }

        if (isset($this->$levelAttribute)) {
            $options['level'] = $this->$levelAttribute;
        } elseif (isset($this->$confirmedValueAttribute)) {
            $options['level'] = Confirmation::LEVEL_CONFIRMED;
        } else {
            $options['level'] = Confirmation::LEVEL_UNCONFIRMED;
        }

        return new Confirmation($options);
    }

    public function getFiles()
    {
        return $this->hasMany(\hipanel\models\File::class, ['object_id' => 'id']);
    }

    public function scenarioCommands()
    {
        return [
            'request-email-confirmation' => 'notify-confirm-email',
            'request-phone-confirmation' => 'notify-confirm-phone',
        ];
    }
}
