<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\models;

use hipanel\behaviors\TaggableBehavior;
use hipanel\behaviors\CustomAttributes;
use hipanel\models\TaggableInterface;
use hipanel\modules\stock\helpers\ProfitColumns;
use yii\helpers\ArrayHelper;
use hipanel\helpers\StringHelper;
use hipanel\modules\client\models\query\ClientQuery;
use hipanel\modules\domain\models\Domain;
use hipanel\modules\finance\models\Purse;
use hipanel\modules\server\models\Server;
use hipanel\modules\finance\models\Target;
use hipanel\validators\DomainValidator;
use Yii;

/**
 * Class Client.
 *
 * @property Contact $contact the primary contact
 * @property Purse[] $purses
 * @property int $id
 * @property-read string $balance
 * @property-read string $credit
 * @property-read string $currency
 * @property-read ClientWithProfit[] $profit
 * @property-read Assignment[] $assignments
 */
class Client extends \hipanel\base\Model implements TaggableInterface
{
    use \hipanel\base\ModelTrait;

    public const TYPE_SELLER = 'reseller';
    public const TYPE_ADMIN = 'admin';
    public const TYPE_MANAGER = 'manager';
    public const TYPE_JUNIOR_MANAGER = 'junior-manager';
    public const TYPE_CLIENT = 'client';
    public const TYPE_OWNER = 'owner';
    public const TYPE_EMPLOYEE = 'employee';
    public const TYPE_SUPPORT = 'support';
    public const TYPE_PARTNER = 'partner';

    public const STATE_OK = 'ok';
    public const STATE_DELETED = 'deleted';
    public const STATE_WIPED = 'wiped';
    public const STATE_BLOCKED = 'blocked';

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'as customAttributes' => CustomAttributes::class,
            [
                'class' => TaggableBehavior::class,
            ],
        ]);
    }

    public function rules()
    {
        return [
            [['id', 'seller_id', 'state_id', 'type_id', 'tariff_id', 'profile_id', 'payment_ticket_id', 'referer_id'], 'integer'],
            [['hipanel_forced'], 'boolean', 'trueValue' => 1],
            [['login', 'seller', 'state', 'type', 'tariff', 'profile', 'referer'], 'string'],
            [['state_label', 'type_label', 'referral', 'roles', 'debt_label'], 'safe'],

            [['profile_ids', 'tariff_ids', 'ids'], 'safe', 'on' => ['update', 'set-tariffs']],
            [['ids'], 'required', 'on' => ['set-tariffs']],
            [['id'], 'required', 'on' => ['update']],
            [['custom_attributes'], 'safe', 'on' => ['update']],

            [['balance', 'credit', 'full_balance', 'template_id'], 'number'],
            [['count', 'confirm_url', 'language', 'comment', 'name', 'currency'], 'safe'],
            [['create_time', 'update_time', 'create_date'], 'date'],
            [['id', 'note'], 'safe', 'on' => 'set-note'],
            [['id', 'description'], 'safe', 'on' => 'set-description'],

            [['id', 'credit'], 'required', 'on' => 'set-credit'],
            [['id', 'type', 'comment'], 'required', 'on' => ['set-block', 'enable-block']],
            [['id'], 'required', 'on' => ['disable-block', 'create-payment-ticket']],
            [['comment'], 'safe', 'on' => ['disable-block']],
            [['id', 'language'], 'required', 'on' => 'set-language'],
            [['id', 'seller_id'], 'required', 'on' => 'set-seller'],

            [['id', 'tariff_ids'], 'required', 'on' => 'set-referral-tariff'],

            [['password', 'email'], 'required', 'on' => ['create']],
            [['type'], 'default', 'value' => self::TYPE_CLIENT, 'on' => ['create', 'update']],
            [['type'], 'in', 'range' => array_keys(self::getTypeOptions()), 'on' => ['create', 'update']],
            [['email'], 'email', 'on' => ['create', 'update']],
            [['referer_id'], 'integer', 'on' => ['create', 'update']],
            [
                ['login'],
                'match',
                'pattern' => '/^[a-z][a-z0-9_]{2,31}$/',
                'message' => Yii::t('hipanel:client', 'Field "{attribute}" can contain Latin characters written in lower case, and it may contain numbers and underscores'),
                'on' => ['create', 'update'],
            ],
            [['login', 'email'], 'unique', 'on' => ['create', 'update']],

            // Ticket settings
            [['ticket_emails', 'create_from_emails'], 'string', 'on' => ['ticket-settings']],
            [
                ['ticket_emails', 'create_from_emails'],
                'filter',
                'filter' => function ($value) {
                    return (mb_strlen($value) > 0) ? StringHelper::mexplode($value) : [];
                },
                'on' => ['ticket-settings'],
            ],
            [['ticket_emails', 'create_from_emails'], 'each', 'rule' => ['email'], 'on' => ['ticket-settings']],
            [['send_message_text', 'new_messages_first'], 'boolean', 'on' => 'ticket-settings'],

            // Finance settings
            [['finance_emails'], 'string', 'on' => 'finance-settings'],
            [
                ['finance_emails'],
                'filter',
                'filter' => function ($value) {
                    return (mb_strlen($value) > 0) ? StringHelper::mexplode($value) : [];
                },
                'on' => ['finance-settings'],
            ],
            [['finance_emails'], 'each', 'rule' => ['email'], 'on' => ['finance-settings']],
            [['autoexchange_enabled', 'autoexchange_force', 'autoexchange_prepayments'], 'boolean', 'on' => ['finance-settings']],
            [['autoexchange_to'], 'string', 'on' => ['finance-settings']],

            // Domain settings
            [
                ['nss'],
                'filter',
                'filter' => function ($value) {
                    return (mb_strlen($value) > 0) ? StringHelper::mexplode($value) : [];
                },
                'on' => 'domain-settings',
            ],

            [['nss'], 'each', 'rule' => [DomainValidator::class, 'enableIdn' => true], 'on' => 'domain-settings'],

            [['autorenewal'], 'boolean', 'on' => 'domain-settings'],
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
            [['allowed_ips', 'sshftp_ips'], 'each', 'rule' => ['ip', 'subnet' => null], 'on' => ['ip-restrictions']],

            // Auto exchange settings
            [['currency'], 'required', 'on' => ['auto-exchange-settings']],
            [['enable_auto', 'force_exchange'], 'boolean', 'on' => ['auto-exchange-settings']],

            // Change password
            [['login', 'old_password', 'new_password', 'confirm_password'], 'required', 'on' => ['change-password']],
            [
                ['old_password'],
                function ($attribute, $params) {
                    $response = $this->perform('check-password', [
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
            [['id'], 'integer', 'on' => ['delete', 'perform-billing']],

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

            [['currencies'], 'safe', 'on' => ['create', 'update']],
            [['id'], 'safe', 'on' => ['create-notifications']],
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
            'referer_id' => Yii::t('hipanel:client', 'Referer'),
            'referer' => Yii::t('hipanel:client', 'Referer'),

            'create_time' => Yii::t('hipanel', 'Registered'),
            'update_time' => Yii::t('hipanel', 'Last update'),

            'ticket_emails' => Yii::t('hipanel:client', 'Email for tickets'),
            'create_from_emails' => Yii::t('hipanel:client', 'Allowed emails for creating tickets'),
            'send_message_text' => Yii::t('hipanel:client', 'Send message text'),

            'allowed_ips' => Yii::t('hipanel:client', 'Allowed IPs for panel login'),
            'sshftp_ips' => Yii::t('hipanel:client', 'Default allowed IPs for SSH/FTP accounts'),

            'old_password' => Yii::t('hipanel', 'Current password'),
            'new_password' => Yii::t('hipanel', 'New password'),
            'confirm_password' => Yii::t('hipanel', 'Confirm password'),

            'is_verified' => Yii::t('hipanel:client', 'Is verified'),
            'custom_attributes' => Yii::t('hipanel:client', 'Additional information'),

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

            // Finance settings
            'finance_emails' => Yii::t('hipanel:client', 'Financial emails'),
            'autoexchange_enabled' => Yii::t('hipanel:client', 'Exchange currency for debts automatically'),
            'autoexchange_to' => Yii::t('hipanel:client', 'Primary currency for invoices'),
            'autoexchange_force' =>  Yii::t('hipanel:client', 'Exchange all debts to primary currency'),
            'autoexchange_prepayments' => Yii::t('hipanel:client', 'Exchange prepayments for the expected resources consumption'),
        ]);
    }

    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'autoexchange_to' => Yii::t('hipanel:client', 'Select the preferred currency for invoices'),
            'autoexchange_enabled' => Yii::t('hipanel:client', 'When the primary currency (say EUR) balance is positive and the secondary currency (say USD) has debts, exchange as much available EUR as possible to close USD debts'),
            'autoexchange_force' => Yii::t('hipanel:client', 'When "exchange currency for debts automatically" is enabled, this flag indicates that the primary currency CAN be indebted to close debts in other currencies'),
            'autoexchange_prepayments' => Yii::t('hipanel:client', 'When "exchange currency for debts automatically" is enabled, this flag indicates that prepayment for the expected resources consumption that was listed in the invoice should be exchanged too. It can be useful to prevent debts in primary currency while the secondary currency balance is positive due to prepayment'),
        ]);
    }

    public function getProfit()
    {
        if (!class_exists(ProfitColumns::class)) {
            return null;
        }

        return $this->hasMany(ClientWithProfit::class, ['id' => 'id'])->indexBy('currency');
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

    public function getTargets()
    {
        if (!Yii::getAlias('@target', false)) {
            return null;
        }

        return $this->hasMany(Target::class, ['client_id' => 'id']);
    }

    public function getAssignments()
    {
        return $this->hasMany(Assignment::class, ['client_id' => 'id']);
    }

    public function getPurses()
    {
        if (!Yii::getAlias('@finance', false)) {
            return null;
        }

        return $this->hasMany(Purse::class, ['client_id' => 'id']);
    }

    public function getPurseByCurrency(string $currency): ?Purse
    {
        if (!$this->isRelationPopulated('purses')) {
            return null;
        }

        foreach ($this->purses as $purse) {
            if ($purse->currency === strtolower($currency)) {
                return $purse;
            }
        }

        return null;
    }

    public function getPrimaryPurse(): ?Purse
    {
        if (!$this->isRelationPopulated('purses')) {
            return null;
        }

        foreach ($this->purses as $purse) {
            if ($purse->id === $this->id) {
                return $purse;
            }
        }

        return null;
    }

    public static function canBeSelf($model)
    {
        return Yii::$app->user->is($model->id) || (!Yii::$app->user->can('resell') && Yii::$app->user->can('support') && Yii::$app->user->identity->seller_id === $model->id);
    }

    public function isBlocked()
    {
        return $this->state === self::STATE_BLOCKED;
    }

    public function canBeBlocked()
    {
        return !$this->isDeleted() && !$this->isBlocked() && Yii::$app->user->can('client.block') && Yii::$app->user->not($this->id);
    }

    public function canBeUnblocked()
    {
        return !$this->isDeleted() && $this->isBlocked() && Yii::$app->user->can('client.unblock') && Yii::$app->user->not($this->id);
    }

    public function isDeleted()
    {
        return in_array($this->state, [self::STATE_WIPED, self::STATE_DELETED], true);
    }

    public function canBeDeleted()
    {
        return !$this->isDeleted() && Yii::$app->user->not($this->id) && Yii::$app->user->can('client.delete');
    }

    public function hasReferralTariff(): bool
    {
        return $this->referral && $this->referral['tariff_id'];
    }

    public function canBeRestored()
    {
        return $this->isDeleted() && Yii::$app->user->can('client.restore');
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
            self::TYPE_JUNIOR_MANAGER => Yii::t('hipanel:client', 'Junior manager'),
            self::TYPE_ADMIN => Yii::t('hipanel:client', 'Administrator'),
            self::TYPE_SUPPORT => Yii::t('hipanel:client', 'Support'),
            self::TYPE_PARTNER => Yii::t('hipanel:client', 'Partner'),
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
            return $getOrder($a->currency) <=> $getOrder($b->currency);
        });

        return $purses;
    }

    public function getLanguage($default = 'ru')
    {
        return $this->language ?: $default;
    }

    public function getBudget(): string
    {
        return $this->balance + $this->credit;
    }

    public function getTariffAssignment(): ?Assignment
    {
        if ($this->isRelationPopulated('assignments')) {
            return ArrayHelper::index($this->assignments, 'type')['tariff'];
        }

        return null;
    }

    public function notMyself(): bool
    {
        return (string)$this->id !== (string)Yii::$app->user->identity->id;
    }

    public function notMySeller(): bool
    {
        return (string)$this->seller_id !== (string)Yii::$app->user->identity->seller_id;
    }

    public function getCustomAttributesList()
    {
        return [
            'special_conditions' => Yii::t('hipanel:client', 'Special Conditions'),
            'rent' => Yii::t('hipanel:client', 'Rent'),
            'buyout' => Yii::t('hipanel:client', 'Buyout'),
            'buyout_by_installment' => Yii::t('hipanel:client', 'Buyout by installment'),
            'support_service' => Yii::t('hipanel:client', 'Support service'),
            'ip_addresses' => Yii::t('hipanel:client', 'IP-addresses'),
            'rack' => Yii::t('hipanel:client', 'Rack'),
            'network' => Yii::t('hipanel:client', 'Network'),
            'vcdn' => Yii::t('hipanel:client', 'vCDN'),
            'acdn' => Yii::t('hipanel:client', 'aCDN'),
            'other_information_links' => Yii::t('hipanel:client', 'Other information/Links'),
        ];
    }
}
