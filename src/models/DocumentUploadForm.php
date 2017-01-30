<?php

namespace hipanel\modules\client\models;

use hipanel\behaviors\File;
use hiqdev\hiart\ResponseErrorException;
use Yii;
use yii\base\Model;

class DocumentUploadForm extends Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string Document title
     */
    public $title;

    /**
     * @var string File itself
     */
    public $file;

    /**
     * @var int
     */
    public $file_id;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => File::class,
                'attribute' => 'file',
                'targetAttribute' => 'file_id',
                'scenarios' => [self::SCENARIO_DEFAULT],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('hipanel:client', 'Document type')
        ];
    }

    public function save()
    {
        $this->trigger('beforeInsert');

        try {
            Contact::perform('attach-document', $this->getAttributes());
        } catch (ResponseErrorException $e) {
            $this->addError('title', $e->getMessage());

            return false;
        }

        return true;
    }
}
