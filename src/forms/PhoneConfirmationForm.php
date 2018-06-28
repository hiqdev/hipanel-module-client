<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\forms;

use hipanel\modules\client\models\Contact;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * Class PhoneConfirmationForm.
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
     * {@inheritdoc}
     */
    public function attributes()
    {
        return ['id', 'phone', 'type', 'code'];
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('hipanel:client', 'Confirmation code'),
            'phone' => Yii::t('hipanel:client', 'Phone'),
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
     * {@inheritdoc}
     */
    public function formName()
    {
        return '';
    }
}
