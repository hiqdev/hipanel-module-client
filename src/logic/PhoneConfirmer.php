<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\logic;

use hipanel\modules\client\forms\PhoneConfirmationForm;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\models\NotifyTries;
use hiqdev\hiart\ResponseErrorException;
use Yii;

class PhoneConfirmer
{
    /**
     * @var PhoneConfirmationForm
     */
    private $model;

    /**
     * @var NotifyTries
     */
    private $notifyTries;

    /**
     * PhoneConfirmer constructor.
     * @param PhoneConfirmationForm $model
     * @param NotifyTries $notifyTries
     */
    public function __construct(PhoneConfirmationForm $model, NotifyTries $notifyTries)
    {
        $this->model = $model;
        $this->notifyTries = $notifyTries;
    }

    /**
     * Requests API to send the phone number confirmation code.
     * @throws PhoneConfirmationException
     * @return bool
     */
    public function requestCode()
    {
        if (!$this->notifyTries->isIntervalSatisfied()) {
            throw new PhoneConfirmationException('Minimum interval between confirmation code requests is not satisfied');
        }
        if (!$this->notifyTries->tries_left) {
            throw new PhoneConfirmationException('Tries are exceeded. Please, contact support.');
        }

        try {
            Contact::perform('notify-confirm-phone', [
                'id' => $this->model->id,
                'type' => $this->model->type,
            ]);
        } catch (ResponseErrorException $e) {
            throw new PhoneConfirmationException('Failed to request code confirmation', 0, $e);
        }

        return true;
    }

    /**
     * Sends the phone number confirmation code to the API.
     *
     * @throws PhoneConfirmationException
     * @return bool whether code was submitted successfully
     */
    public function submitCode()
    {
        if (!$this->model->validate()) {
            throw new PhoneConfirmationException('Form validation failed');
        }

        try {
            Contact::perform('confirm-phone', [
                'id' => $this->model->id,
                'type' => $this->model->type,
                'phone' => $this->model->phone,
                'code' => $this->model->code,
            ]);
        } catch (ResponseErrorException $e) {
            if ($e->getMessage() === 'wrong code') {
                throw new PhoneConfirmationException(Yii::t('hipanel:client', 'Wrong confirmation code'));
            }

            throw new PhoneConfirmationException($e->getMessage());
        }

        return true;
    }
}
