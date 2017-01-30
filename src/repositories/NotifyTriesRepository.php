<?php

namespace hipanel\modules\client\repositories;

use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\NotifyTries;
use hiqdev\hiart\ErrorResponseException;
use yii\db\ActiveRecordInterface;

class NotifyTriesRepository
{
    /**
     * @param Contact|ActiveRecordInterface $contact
     * @param string $type
     * @return NotifyTries|null
     */
    public function getTriesForContact(Contact $contact, $type)
    {
        try {
            $data = Contact::perform('get-notify-tries', ['id' => $contact->id, 'type' => $type]);
            return new NotifyTries($data);
        } catch (ErrorResponseException $e) {
            return null;
        }
    }
}
