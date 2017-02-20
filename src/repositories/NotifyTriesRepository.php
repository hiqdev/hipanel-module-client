<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\repositories;

use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\NotifyTries;
use hiqdev\hiart\ResponseErrorException;
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
        } catch (ResponseErrorException $e) {
            return null;
        }
    }
}
