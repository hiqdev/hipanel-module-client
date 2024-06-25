<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\modules\client\models\query\BlacklistQuery;
use Yii;

class Blacklist extends \hipanel\base\Model
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

    public function rules()
    {
        return [
            [['id', 'obj_id', 'type_id', 'state_id', 'client_id', 'object_id'], 'integer'],
            [['name', 'message', 'state', 'type', 'client'], 'string'],
            [['create_time'], 'date'],
            [['show_message'], 'boolean'],

            [['type', 'name'], 'required', 'on' => ['create']],
            [['name'], 'required', 'on' => 'update'],

            // Delete
            [['id'], 'integer', 'on' => ['delete']],

            [['created', 'category'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'name' => Yii::t('hipanel:client', 'Name'),
            'type' => Yii::t('hipanel:client', 'Type'),
            'message' => Yii::t('hipanel:client', 'Message'),
            'show_message' => Yii::t('hipanel:client', 'Show message'),
            'client' => Yii::t('hipanel:client', 'Client'),
            'status' => Yii::t('hipanel:client', 'Status'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return BlacklistQuery
     */
    public static function find($options = [])
    {
        return new BlacklistQuery(static::class, [
            'options' => $options,
        ]);
    }
}
