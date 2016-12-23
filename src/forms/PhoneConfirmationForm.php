<?php

namespace hipanel\modules\client\forms;

use hipanel\modules\client\models\Contact;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class PhoneConfirmationForm
 *
 * @package hipanel\modules\client\forms
 */
class PhoneConfirmationForm extends Model
{
    const TYPE_PHONE = 'voice_phone';
    const TYPE_FAX = 'fax_phone';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $code;

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['id', 'phone', 'type', 'code'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['code', 'type', 'phone'], 'safe'],

            [['id', 'code', 'type', 'phone'], 'required', 'on' => 'check'],
            [['id', 'type', 'phone'], 'required', 'on' => 'request'],
        ];
    }

    /**
     * @param Contact|ActiveRecord $contact
     * @param $type
     * @return static
     */
    public static function fromContact($contact, $type)
    {
        return new static([
            'id' => $contact->id,
            'phone' => $contact->$type,
            'type' => $type,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return '';
    }
}
