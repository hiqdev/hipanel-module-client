<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\behaviors\CustomAttributes;
use hipanel\behaviors\TaggableBehavior;
use hipanel\models\TaggableInterface;
use Yii;

class Blacklist extends \hipanel\base\Model implements TaggableInterface
{
    use \hipanel\base\ModelTrait;

    public const TYPE_DOMAIN = 'domain';
    public const TYPE_IP = 'ip';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PURSE = 'purse';

    public const STATE_OK = 'ok';
    public const STATE_DELETED = 'deleted';

    public static function tableName(): string
    {
        return 'blacklisted';
    }

    public function behaviors(): array
    {
        return array_merge(parent::behaviors(), [
            'as customAttributes' => CustomAttributes::class,
            [
                'class' => TaggableBehavior::class,
            ],
        ]);
    }

    public function rules(): array
    {
        return [
            [['id', 'obj_id', 'type_id', 'state_id', 'client_id', 'object_id'], 'integer'],
            [['name', 'message', 'state', 'type', 'client'], 'string'],
            [['last_notified'], 'timestamp'],
            [['show_message'], 'boolean'],
            //[['type'], 'default', 'value' => self::TYPE_DOMAIN, 'on' => ['create', 'update']],
            //[['type'], 'in', 'range' => array_keys(self::getTypeOptions()), 'on' => ['create', 'update']],
            [['client', 'state', 'type'], 'safe'],
            [['client_name'], 'safe'],
//            [['state_label', 'type_label'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'login' => Yii::t('hipanel:client', 'Login'),
        ]);
    }

    /*public static function getTypeOptions(): array
    {
        return [
            self::TYPE_DOMAIN => Yii::t('hipanel:client', 'Domain'),
            self::TYPE_IP => Yii::t('hipanel:client', 'Ip'),
            self::TYPE_EMAIL => Yii::t('hipanel:client', 'Email'),
            self::TYPE_PURSE => Yii::t('hipanel:client', 'Purse'),
        ];
    }*/
}
