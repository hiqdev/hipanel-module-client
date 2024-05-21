<?php declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\behaviors\CustomAttributes;
use hipanel\behaviors\TaggableBehavior;
use hipanel\models\TaggableInterface;
use Yii;

class Blacklist extends \hipanel\base\Model implements TaggableInterface
{
    public static function tableName(): string
    {
        return 'blacklisted';
    }

    public function behaviors()
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
            [['name', 'message'], 'string'],
            [['last_notified'], 'timestamp'],
            [['show_message'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return $this->mergeAttributeLabels([
            'login' => Yii::t('hipanel:client', 'Login'),
        ]);
    }

    public function getClient()
    {
        return $this->hasOne(Client::class, ['obj_id' => 'client_id']);
    }

    public function getObject()
    {
        return $this->hasOne(Obj::class, ['obj_id' => 'object_id']);
    }

    public function getState()
    {
        return $this->hasOne(Type::class, ['obj_id' => 'state_id']);
    }

    public function getType()
    {
        return $this->hasOne(Type::class, ['obj_id' => 'type_id']);
    }
}