<?php

namespace hipanel\modules\client\repositories;

use hipanel\components\ApiConnectionInterface;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\NotifyTries;
use hiqdev\hiart\ErrorResponseException;
use yii\db\ActiveRecordInterface;

class NotifyTriesRepository
{
    /**
     * @var ApiConnectionInterface
     */
    private $api;

    public function __construct(ApiConnectionInterface $api)
    {
        $this->api = $api;
    }

    /**
     * @param Contact|ActiveRecordInterface $contact
     * @param string $type
     * @return NotifyTries|null
     */
    public function getTriesForContact(Contact $contact, $type)
    {
        try {
            $data = $this->api->get('contactGetNotifyTries', ['id' => $contact->id, 'type' => $type]);
            return new NotifyTries($data);
        } catch (ErrorResponseException $e) {
            return null;
        }
    }
}
