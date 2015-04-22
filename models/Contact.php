<?php
/**
 * @link    http://hiqdev.com/hipanel
 * @license http://hiqdev.com/hipanel/license
 * @copyright Copyright (c) 2015 HiQDev
 */

namespace hipanel\modules\client\models;

use Yii;

class Contact extends \hipanel\base\Model
{
    /**
     * @return array the list of attributes for this record
     */

    use \hipanel\base\ModelTrait;

    public function rules()
    {
        return [
            [[ 'id', 'obj_id', 'client_id', 'seller_id' ],                  'integer'],
            [[ 'type_id', 'state_id' ],                                     'integer'],
            [[ 'create_time', 'update_time', 'created_date', 'updated_date' ], 'date'],
            [[ 'client', 'seller', 'state', 'type' ],                       'safe'],
            [[ 'email', 'abuse_email' ],                                    'email'],
            [[ 'country', 'country_name', 'province', 'province_name' ],    'safe'],
            [[ 'postal_code' ],                                             'safe'],
            [[ 'city', 'street1', 'street2', 'street3' ],                   'safe'],
            [[ 'voice_phone', 'fax_phone' ],                                'safe'],
            [[ 'icq', 'skype', 'jabber' ],                                  'safe'],
            [[ 'roid', 'epp_id', 'remoteid' ],                              'safe'],
            [[ 'name', 'first_name', 'last_name' ],                         'safe'],
            [[ 'birth_date', 'passport_date' ],                             'date'],
            [[ 'passport_no', 'passport_by', 'organization', 'password' ],  'safe' ],
            [[ 'remote'] , 'safe'],
            [[ 'email_confirmed' ],                                         'boolean' ],
        ];
    }

    public function attributeLabels () {
        return $this->mergeAttributeLabels([
            'create_time'           => Yii::t('app', 'Create time'),
            'update_time'           => Yii::t('app', 'Update time'),
            'passport_no'           => Yii::t('app', 'Passport number'),
            'passport_by'           => Yii::t('app', 'Passport by'),
            'passport_date'         => Yii::t('app', 'Passport date'),
        ]);
    }

}
