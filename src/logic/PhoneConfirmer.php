<?php

namespace hipanel\modules\client\logic;

use hipanel\components\ApiConnectionInterface;
use hipanel\modules\client\forms\PhoneConfirmationForm;
use hipanel\modules\client\models\NotifyTries;
use hiqdev\hiart\ErrorResponseException;
use Yii;

class PhoneConfirmer
{
    /**
     * @var PhoneConfirmationForm
     */
    private $model;
    /**
     * @var ApiConnectionInterface
     */
    private $api;
    /**
     * @var NotifyTries
     */
    private $notifyTries;

    /**
     * PhoneConfirmer constructor
     * @param PhoneConfirmationForm $model
     * @param NotifyTries $notifyTries
     * @param ApiConnectionInterface $api
     */
    public function __construct(PhoneConfirmationForm $model, NotifyTries $notifyTries, ApiConnectionInterface $api)
    {
        $this->model = $model;
        $this->api = $api;
        $this->notifyTries = $notifyTries;
    }

    /**
     * Requests API to send the phone number confirmation code
     *
     * @return bool
     * @throws PhoneConfirmationException
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
            $this->api->post('contactNotifyConfirmPhone', ['id' => $this->model->id, 'type' => $this->model->type]);
        } catch (ErrorResponseException $e) {
            throw new PhoneConfirmationException('Failed to request code confirmation', $e);
        }

        return true;
    }

    /**
     * Sends the phone number confirmation code to the API
     *
     * @return bool whether code was submitted successfully
     * @throws PhoneConfirmationException
     */
    public function submitCode()
    {
        if (!$this->model->validate()) {
            throw new PhoneConfirmationException('Form validation failed');
        }

        try {
            $this->api->post('contactConfirmPhone', [
                'id' => $this->model->id,
                'type' => $this->model->type,
                'phone' => $this->model->phone,
                'code' => $this->model->code,
            ]);
        } catch (ErrorResponseException $e) {
            if ($e->getMessage() === 'wrong code') {
                throw new PhoneConfirmationException(Yii::t('hipanel:client', 'Wrong confirmation code'));
            }

            throw new PhoneConfirmationException($e->getMessage());
        }

        return true;
    }
}
