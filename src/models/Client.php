<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use hipanel\helpers\StringHelper;
use hipanel\models\Ref;
use hipanel\modules\client\forms\EmployeeForm;
use hipanel\modules\client\models\query\ClientQuery;
use hipanel\modules\domain\models\Domain;
use hipanel\modules\finance\models\Purse;
use hipanel\modules\server\models\Server;
use hipanel\modules\ticket\models\Thread;
use hipanel\validators\DomainValidator;
use Yii;

/**
 * Class Client
 *
 * @property Contact $contact the primary contact
 * @property Purse[] $purses
 */
class Client extends \hipanel\base\Model
{
    use \hipanel\base\ModelTrait;

    const TYPE_SELLER = 'reseller';
    const TYPE_ADMIN = 'admin';
    const TYPE_MANAGER = 'manager';
    const TYPE_CLIENT = 'client';
    const TYPE_OWNER = 'owner';
    const TYPE_EMPLOYEE = 'employee';

    const STATE_OK = 'ok';
    const STATE_DELETED = 'deleted';
    const STATE_BLOCKED = 'blocked';

    public function rules()
    {
        return [
            [['id', 'seller_id', 'state_id', 'type_id', 'tariff_id', 'profile_id', 'payment_ticket_id'], 'integer'],
            [['login', 'seller', 'state', 'type', 'tariff', 'profile' ], 'safe'],
            [['state_label', 'type_label'], 'safe'],
            [['balance', 'credit'], 'number'],
            [['count', 'confirm_url', 'language', 'comment', 'name', 'currency', 'financial_month'], 'safe'],
            [['create_time', 'update_time', 'last_deposit'], 'date'],
            [['id', 'note'], 'safe', 'on' => 'set-note'],
            [['id', 'description'], 'safe', 'on' => 'set-description'],

            [['id', 'credit'], 'required', 'on' => 'set-credit'],
            [['id', 'type', 'comment'], 'required', 'on' => ['set-block', 'enable-block']],
            [['id'], 'required', 'on' => ['disable-block', 'create-payment-ticket']],
            [['comment'], 'safe', 'on' => ['disable-block']],
            [['id', 'language'], 'required', 'on' => 'set-language'],
            [['id', 'seller_id'], 'required', 'on' => 'set-seller'],

            [['password', 'login', 'seller_id', 'email'], 'required', 'on' => ['create']],
            [['type'], 'default', 'value' => self::TYPE_CLIENT, 'on' => ['create', 'update']],
            [['type'], 'in', 'range' => array_keys(self::getTypeOptions()), 'on' => ['create', 'update']],
            [['email'], 'email', 'on' => ['create', 'update']],
            [
                ['login'],
                'match',
                'pattern' => '/^[a-z][a-z0-9_]{2,31}$/',
                'message' => Yii::t('hipanel:client', 'Field "{attribute}" can contain Latin characters written in lower case, and it may contain numbers and underscores'),
                'on' => ['create', 'update'],
            ],
            [['login', 'email'], 'unique', 'on' => ['create', 'update']],

            // Ticket settings
            [['ticket_emails'], 'string', 'max' => 128, 'on' => 'ticket-settings'],
            [['ticket_emails'], 'email', 'on' => 'ticket-settings'],
            [['send_message_text', 'new_messages_first'], 'boolean', 'on' => 'ticket-settings'],

            // Domain settings
            [
                ['nss'],
                'filter',
                'filter' => function ($value) {
                    return (mb_strlen($value) > 0) ? StringHelper::mexplode($value) : [];
                },
                'on' => 'domain-settings',
            ],
            [['nss'], 'each', 'rule' => [DomainValidator::class], 'on' => 'domain-settings'],
            [['autorenewal', 'whois_protected'], 'boolean', 'on' => 'domain-settings'],
            [['registrant', 'admin', 'tech', 'billing'], 'safe', 'on' => 'domain-settings'],

            // Mailings/Notification settings
            [
                [
                    'notify_important_actions',
                    'domain_registration',
                    'newsletters',
                    'commercial',
                    'monthly_invoice',
                    'financial',
                ],
                'boolean',
                'on' => ['mailing-settings'],
            ],

            // IP address restrictions
            [
                ['allowed_ips', 'sshftp_ips'],
                'filter',
                'filter' => function ($value) {
                    if (!is_array($value)) {
                        return (mb_strlen($value) > 0) ? StringHelper::mexplode($value) : true;
                    } else {
                        return $value;
                    }
                },
                'skipOnEmpty' => true,
                'on' => ['ip-restrictions'],
            ],
            [['allowed_ips', 'sshftp_ips'], 'each', 'rule' => ['ip'], 'on' => ['ip-restrictions']],

            // Change password
            [['login', 'old_password', 'new_password', 'confirm_password'], 'required', 'on' => ['change-password']],
            [
                ['old_password'],
                function ($attribute, $params) {
                    $response = $this->perform('CheckPassword', [
                        'password' => $this->{$attribute},
                        'login' => $this->login,
                    ]);
                    if (!$response['matches']) {
                        $this->addError($attribute, Yii::t('hipanel:client', 'The password is incorrect'));
                    }
                },
                'on' => ['change-password'],
            ],
            // Client validation disabled due the Yii2 bug: https://github.com/yiisoft/yii2/issues/9811
            [
                ['confirm_password'],
                'compare',
                'compareAttribute' => 'new_password',
                'enableClientValidation' => false,
                'on' => ['change-password'],
            ],

            // Delete
            [['id'], 'integer', 'on' => 'delete'],

            // Set temporary password
            [['id'], 'integer', 'on' => 'set-tmp-password'],

            // TOTP
            [['totp_enabled'], 'boolean'],

            // Pincode
            [['enable', 'disable', 'pincode_enabled'], 'boolean', 'on' => ['pincode-settings']],
            [['question', 'answer'], 'string', 'on' => ['pincode-settings']],
            [['pincode'], 'string', 'min' => 4, 'max' => 4],

            // If pincode disabled
            [
                ['pincode', 'answer', 'question'],
                'required',
                'enableClientValidation' => false,
                'when' => function ($model) {
                    return $model->pincode_enabled === false;
                },
                'on' => ['pincode-settings'],
            ],

            // If pincode enabled
            [
                ['pincode'],
                'required',
                'when' => function ($model) {
                    return (empty($model->answer) && $model->pincode_enabled) ? true : false;
                },
                'enableClientValidation' => false,
                'message' => Yii::t('hipanel:client', 'Fill the Pincode or answer to the question.'),
                'on' => ['pincode-settings'],
            ],

            [
                ['answer'],
                'required',
                'when' => function ($model) {
                    return (empty($model->pincode) && $model->pincode_enabled) ? true : false;
                },
                'enableClientValidation' => false,
                'message' => Yii::t('hipanel:client', 'Fill the Answer or enter the Pincode.'),
                'on' => ['pincode-settings'],
            ],

            [['is_verified'], 'boolean', 'on' => ['set-verified']],
        ];
    }

    public function getClient()
    {
        return $this->login;
    }

    public function getClient_id()
    {
        return $this->id;
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'login' => Yii::t('hipanel:client', 'Login'),

            'create_time' => Yii::t('hipanel', 'Registered'),
            'update_time' => Yii::t('hipanel', 'Last update'),

            'ticket_emails' => Yii::t('hipanel:client', 'Email for tickets'),
            'send_message_text' => Yii::t('hipanel:client', 'Send message text'),

            'allowed_ips' => Yii::t('hipanel:client', 'Allowed IPs for panel login'),
            'sshftp_ips' => Yii::t('hipanel:client', 'Default allowed IPs for SSH/FTP accounts'),

            'old_password' => Yii::t('hipanel', 'Current password'),
            'new_password' => Yii::t('hipanel', 'New password'),
            'confirm_password' => Yii::t('hipanel', 'Confirm password'),

            'is_verified' => Yii::t('hipanel:client', 'Is verified'),

            // Mailing/Notification settings
            'notify_important_actions' => Yii::t('hipanel:client', 'Notify important actions'),
            'domain_registration' => Yii::t('hipanel:client', 'Domain registration'),
            'newsletters' => Yii::t('hipanel:client', 'Newsletters'),
            'commercial' => Yii::t('hipanel:client', 'Commercial'),
            'monthly_invoice' => Yii::t('hipanel:client', 'Monthly invoice'),
            'financial' => Yii::t('hipanel:client', 'Payment notification'),

            // Domain settings
            'autorenewal' => Yii::t('hipanel', 'Autorenewal'),
            'nss' => Yii::t('hipanel', 'Name servers'),
            'whois_protected' => Yii::t('hipanel:client', 'WHOIS protect'),
            'registrant' => Yii::t('hipanel:client', 'Registrant contact'),
            'admin' => Yii::t('hipanel:client', 'Admin contact'),
            'tech' => Yii::t('hipanel:client', 'Tech contact'),
            'billing' => Yii::t('hipanel:client', 'Billing contact'),

            // Pincode
            'pincode' => Yii::t('hipanel:client', 'Enter pincode'),
            'question' => Yii::t('hipanel:client', 'Choose question'),
            'answer' => Yii::t('hipanel:client', 'Answer'),
        ]);
    }

    public function getTicketSettings()
    {
        return $this->hasOne(ClientTicketSettings::class, ['id', 'id']);
    }

    public function getContact()
    {
        return $this->hasOne(Contact::class, ['id' => 'id']);
    }

    public function getDomains()
    {
        if (!Yii::getAlias('@domain', false)) {
            return null;
        }

        return $this->hasMany(Domain::class, ['client_id' => 'id']);
    }

    public function getServers()
    {
        if (!Yii::getAlias('@server', false)) {
            return null;
        }

        return $this->hasMany(Server::class, ['client_id' => 'id']);
    }

    public function getPayment_ticket()
    {
        if (!Yii::getAlias('@ticket', false)) {
            return null;
        }
        return $this->hasOne(Thread::class, ['id' => 'payment_ticket_id']);
    }

    public function getPurses()
    {
        if (!Yii::getAlias('@finance', false)) {
            return null;
        }

        return $this->hasMany(Purse::class, ['client_id' => 'id']);
    }

    public static function canBeSelf($model)
    {
        return Yii::$app->user->is($model->id) || (!Yii::$app->user->can('resell') && Yii::$app->user->can('support') && Yii::$app->user->identity->seller_id === $model->id);
    }

    public static function makeTranslateQuestionList(array $questionList)
    {
        $translation = [
            'q1' => Yii::t('hipanel:client', 'What was your nickname when you were a child?'),
            'q2' => Yii::t('hipanel:client', 'What was the name of your best childhood friend?'),
            'q3' => Yii::t('hipanel:client', 'What is the month and the year of birth of your oldest relative? (e.g. January, 1900)'),
            'q4' => Yii::t('hipanel:client', 'What is your grandmother’s maiden name?'),
            'q5' => Yii::t('hipanel:client', 'What is the patronymic of your oldest relative?'),
        ];
        $result = [];
        foreach ($questionList as $k => $v) {
            $result[$translation[$k]] = $translation[$k];
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     * @return ClientQuery
     */
    public static function find($options = [])
    {
        return new ClientQuery(get_called_class(), [
            'options' => $options,
        ]);
    }

    public function scenarioActions()
    {
        return [
            'change-password' => 'set-password',
            'pincode-settings' => $this->pincode_enabled ? 'disable-pincode' : 'enable-pincode',
        ];
    }

    public static function getTypeOptions()
    {
        $types = [
            self::TYPE_CLIENT => Yii::t('hipanel:client', 'Client'),
            self::TYPE_SELLER => Yii::t('hipanel:client', 'Reseller'),
            self::TYPE_MANAGER => Yii::t('hipanel:client', 'Manager'),
            self::TYPE_ADMIN => Yii::t('hipanel:client', 'Administrator'),
        ];

        if (Yii::$app->user->can('employee.read')) {
            $types[self::TYPE_EMPLOYEE] = Yii::t('hipanel:client', 'Employee');
        }

        return $types;
    }

    /**
     * Sort related purses like `usd`, `eur`, other...
     *
     * @return array
     */
    public function getSortedPurses()
    {
        $purses = $this->purses;
        if (empty($purses)) {
            return $purses;
        }

        $getOrder = function ($currency) {
            $order = ['usd' => 0, 'eur' => 1];
            return $order[$currency] ?? 100;
        };

        usort($purses, function ($a, $b) use ($getOrder) {
            return $getOrder($a->currency) <> $getOrder($b->currency);
        });

        return $purses;
    }
}
