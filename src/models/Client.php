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

use Exception;
use hipanel\helpers\StringHelper;
use hipanel\modules\domain\models\Domain;
use hipanel\validators\DomainValidator;
use hipanel\validators\IpValidator;
use Yii;

class Client extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const TYPE_SELLER = 'seller';
    const TYPE_ADMIN = 'admin';
    const TYPE_MANAGER = 'manager';
    const TYPE_CLIENT = 'client';
    const TYPE_OWNER = 'owner';

    const STATE_OK = 'ok';
    const STATE_DELETED = 'deleted';
    const STATE_BLOCKED = 'blocked';

    public function rules()
    {
        return [
            [['id', 'seller_id', 'state_id', 'type_id', 'tariff_id', 'profile_id'],             'integer'],
            [['login', 'seller', 'state', 'type', 'tariff', 'profile'],                         'safe'],
            [['state_label', 'type_label'],                                                     'safe'],
            [['balance', 'credit'],                                                             'number'],
            [['purses'],                                                                        'safe'],
            [['count', 'confirm_url', 'language', 'comment', 'name', 'contact', 'currency'],    'safe'],
            [['create_time', 'update_time'],                                                    'date'],

            [['id', 'credit'],                              'required', 'on' => 'set-credit'],
            [['id', 'type', 'comment'],                     'required', 'on' => ['set-block', 'enable-block', 'disable-block']],
            [['id', 'language'],                            'required', 'on' => 'set-language'],
            [['id', 'seller_id'],                           'required', 'on' => 'set-seller'],

            [['password', 'client', 'seller_id', 'email'],  'required', 'on' => ['create', 'update']],
            [['email'],                                     'email',    'on' => ['create', 'update']],

            // Ticket settings
            [['ticket_emails'],                             'string',   'max' => 128, 'on' => 'ticket-settings'],
            [['ticket_emails'],                             'email',    'on' => 'ticket-settings'],
            [['send_message_text', 'new_messages_first'],   'boolean',  'on' => 'ticket-settings'],

            // Domain settings
            [['nss'], 'filter', 'filter' => function($value) {
                return (mb_strlen($value) > 0 ) ? StringHelper::mexplode($value) : [];
            }, 'on' => 'domain-settings'],
            [['nss'], 'each', 'rule' => [DomainValidator::className()], 'on' => 'domain-settings'],
            [['autorenewal', 'whois_protected'], 'boolean', 'on' => 'domain-settings'],
            [['registrant', 'admin', 'tech', 'billing'], 'safe', 'on' => 'domain-settings'],

            // Mailings
            [[
                'notify_important_actions',
                'domain_registration',
                'send_expires_when_autorenewed',
                'newsletters',
                'commercial',
            ], 'boolean', 'on' => ['mailing-settings']],

            // IP address restrictions
            [['allowed_ips', 'sshftp_ips'], 'filter', 'filter' => function($value) {
                if (!is_array($value)) {
                    return (mb_strlen($value) > 0 ) ? StringHelper::mexplode($value) : true;
                } else {
                    return $value;
                }
            }, 'skipOnEmpty' => true, 'on' => ['ip-restrictions']],
            [['allowed_ips', 'sshftp_ips'], 'each', 'rule' => [IpValidator::className()], 'skipOnEmpty' => true, 'on' => ['ip-restrictions']],

            // Change password
            [['login', 'old_password', 'new_password', 'confirm_password'], 'required', 'on' => ['change-password']],
            [['old_password'], function ($attribute, $params) {
                $response = $this->perform('CheckPassword', [$attribute => $this->$attribute, 'login' => $this->login]);
                if ($response['check'] != 'ok') {
                    $this->addError($attribute, 'The password is incorrect.');
                }
            }, 'on' => ['change-password']],
            // Client validation disabled due the Yii2 bug: https://github.com/yiisoft/yii2/issues/9811
            [['confirm_password'], 'compare', 'compareAttribute' => 'new_password', 'enableClientValidation' => false, 'on' => ['change-password']],

            // Pincode
            [['enable', 'disable', 'pincode_enabled'], 'boolean', 'on' => ['pincode-settings']],
            [['question', 'answer'], 'string', 'on' => ['pincode-settings']],

            // If pincode disabled
            [['pincode', 'answer', 'question'], 'required', 'enableClientValidation' => false, 'when' => function($model) {
                return $model->pincode_enabled == false;
            }, 'on' => ['pincode-settings']],

            // If pincode enabled
            [['pincode'], 'required', 'when' => function($model) {
                return (mb_strlen($model->answer) > 0 && $model->pincode_enabled == true) ? false : true;
            }, 'enableClientValidation' => false, 'message' => Yii::t('app', 'Fill the Pincode or answer to the question.'), 'on' => ['pincode-settings']],

            [['answer'], 'required', 'when' => function($model) {
                return (mb_strlen($model->pincode) > 0 && $model->pincode_enabled == true) ? false : true;
            }, 'enableClientValidation' => false, 'message' => Yii::t('app', 'Fill the Answer or enter the Pincode.'), 'on' => ['pincode-settings']],

            [['pincode'], function ($attribute, $params) {
                try {
                    $response = $this->perform('CheckPincode', [$attribute => $this->$attribute, 'id' => $this->id]);
                } catch (Exception $e) {
                    $this->addError($attribute, Yii::t('app', 'Wrong pincode'));
                }
            }, 'on' => ['pincode-settings']],

            [['answer'], function ($attribute, $params) {
                try {
                    $response = $this->perform('CheckPincode', [$attribute => $this->$attribute, 'id' => $this->id]);
                } catch (Exception $e) {
                    $this->addError($attribute, Yii::t('app', 'Wrong answer'));
                }
            }, 'on' => ['pincode-settings']],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'client_like' => Yii::t('app', 'Client'),
            'seller_like' => Yii::t('app', 'Reseller'),
            'create_time' => Yii::t('app', 'Registered'),
            'update_time' => Yii::t('app', 'Last update'),

            'ticket_emails' => Yii::t('app', 'Email for tickets'),
            'send_message_text' => Yii::t('app', 'Send message text'),

            'allowed_ips' => Yii::t('app', 'Allowed IPs for panel login'),
            'sshftp_ips' => Yii::t('app', 'Default allowed IPs for SSH/FTP accounts'),

            'old_password' => Yii::t('app', 'Current password'),
            'new_password' => Yii::t('app', 'New password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),

            // Domain settings
            'autorenewal' => Yii::t('app', 'Autorenewal'),
            'nss' => Yii::t('app', 'Nameservers'),
            'whois_protected' => Yii::t('app', 'WHOIS protect'),
            'registrant' => Yii::t('app', 'Registrant contact'),
            'admin' => Yii::t('app', 'Admin contact'),
            'tech' => Yii::t('app', 'Tech contact'),
            'billing' => Yii::t('app', 'Billing contact'),

            // Pincode
            'pincode' => Yii::t('app', 'Enter pincode'),
            'question' => Yii::t('app', 'Choose question'),
            'answer' => Yii::t('app', 'Answer'),
        ]);
    }

    public function getTicketSettings() {
        return $this->hasOne(ClientTicketSettings::className(), ['id', 'id']);
    }

    public function getDomains() {
        return $this->hasMany(Domain::className(), ['client_id' => 'id']);
    }

    public static function canBeSelf($model)
    {
        return Yii::$app->user->is($model->id) || (!Yii::$app->user->can('resell') && Yii::$app->user->can('support') && Yii::$app->user->identity->seller_id == $model->id);
    }

    public static function makeTranslateQuestionList(array $questionList)
    {
        $translation = [
            'q1' => Yii::t('app', 'What was your nickname when you were a child?'),
            'q2' => Yii::t('app', 'What was the name of your best childhood friend?'),
            'q3' => Yii::t('app', 'What is the month and the year of birth of your oldest relative? (e.g. January, 1900)'),
            'q4' => Yii::t('app', 'What is your grandmother’s maiden name?'),
            'q5' => Yii::t('app', 'What is the patronymic of your oldest relative?'),
        ];
        $result = [];
        foreach ($questionList as $k => $v) {
            $result[$translation[$k]] = $translation[$k];
        }
        return $result;
    }
}