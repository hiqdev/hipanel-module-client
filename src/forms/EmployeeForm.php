<?php

namespace hipanel\modules\client\forms;

use hipanel\modules\client\models\Contact;
use hipanel\modules\document\models\Document;
use hiqdev\hiart\Collection;
use hiqdev\hiart\ResponseErrorException;
use Yii;

/**
 * Class EmployeeForm represents form for employee management
 */
class EmployeeForm
{
    /**
     * Default contact language
     */
    const LANGUAGE_DEFAULT = 'en';

    /**
     * @var array Available contact languages
     */
    protected $languages = [self::LANGUAGE_DEFAULT, 'uk'];

    /**
     * @var Contact[] contacts available for editing
     */
    protected $contacts = [];

    /**
     * @var string the scenario that will be used for all models
     */
    protected $scenario;

    /**
     * @var Document the contract
     */
    protected $contract;

    /**
     * @param Contact $contact
     * @param $scenario
     */
    public function __construct(Contact $contact, $scenario)
    {
        $this->scenario = $scenario;
        $this->contacts = $this->extractContacts($contact);
        if (Yii::$app->user->can('document.read')) {
            $this->contract = $this->extractContract($contact);
        }
    }

    /**
     * Extracts all the contacts available in the $contact model
     *
     * @param Contact $contact
     * @return array
     */
    protected function extractContacts(Contact $contact)
    {
        $result = [];

        foreach ($this->languages as $language) {
            $result[$language] = $this->contactLocalization($contact, $language);
        }

        return $result;
    }

    /**
     * Extracts contract out of documents array
     *
     * @param Contact $contact
     * @return null|Document
     */
    protected function extractContract($contact)
    {
        foreach ($contact->documents as $document) {
            if ($document->type === 'contract') {
                $document->scenario = $this->scenario;

                return $document;
            }
        }

        return null;
    }

    /**
     * @return Contact[]
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getPrimaryContact()->getName();
    }

    /**
     * Returns primary contact
     *
     * @return Contact|mixed
     */
    public function getPrimaryContact()
    {
        return $this->contacts[self::LANGUAGE_DEFAULT];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getPrimaryContact()->id;
    }

    /**
     * @param string $localization
     * @return Contact|mixed|null
     */
    public function getContact($localization)
    {
        return isset($this->contacts[$localization]) ? $this->contacts[$localization] : null;
    }

    /**
     * @param array $data
     * @return bool whether data was loaded successfully
     */
    public function load($data)
    {
        if ($contacts = $data['Contact']) {
            $this->loadContacts($contacts, $data['pincode']);
        }

        if ($contract = $data['Document']) {
            $this->loadContract($contract);
        }

        return true;
    }

    /**
     * @return Document|null
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Validates all models of the form
     *
     * @return true|string
     */
    public function validate()
    {
        $contacts = $this->getContactsCollection();
        if (!$contacts->validate()) {
            return $contacts->getFirstError();
        }

        if ($this->getContract() !== null) {
            if (!$this->getContract()->validate()) {
                return reset($this->getContract()->getFirstErrors());
            }
        }

        return true;
    }

    /**
     * Saves all model of the form
     *
     * @return bool
     */
    public function save()
    {
        $collection = $this->getContactsCollection();

        try {
            $contractSaved = true;
            $contactsSaved = $collection->save();

            if ($this->getContract() !== null) {
                $this->getContract()->save();
            }

            return $contactsSaved && $contractSaved;
        } catch (ResponseErrorException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Returns fields available for editing in the contract information
     *
     * @return array
     */
    public function getContractFields()
    {
        return [
            'no' => Yii::t('hipanel:client', 'Number'),
            'date' => Yii::t('hipanel:client', 'Date'),
            'provided_services_en' => Yii::t('hipanel:client', 'Provided services (en)'),
            'provided_services_uk' => Yii::t('hipanel:client', 'Provided services (uk)'),
        ];
    }

    /**
     * Loads contact from the $data array.
     * Sets $pincode to each model
     *
     * @param array $data
     * @param string $pincode
     * @return bool whether data was loaded successfully
     */
    protected function loadContacts($data, $pincode)
    {
        $success = true;

        foreach ($data as $datum) {
            if (!isset($datum['localization'])) {
                continue;
            }

            $localization = $datum['localization'];
            $contact = $this->getContact($localization);
            if ($contact === null) {
                continue;
            }

            if (!$contact->load($datum, '')) {
                $success = false;
                continue;
            }

            $contact->pincode = $pincode;
        }

        return $success;
    }

    /**
     * Gets localized version of this contact
     *
     * @param $originalContact
     * @param $language
     * @param bool $createWhenNotExists
     * @return Contact
     */
    protected function contactLocalization($originalContact, $language, $createWhenNotExists = true)
    {
        $originalContact->scenario = $this->scenario;

        if ($language === self::LANGUAGE_DEFAULT) {
            $originalContact->localization = $language;

            return $originalContact;
        }

        foreach ($originalContact->localizations as $contact) {
            if ($contact->localization === $language) {
                $contact->scenario = $this->scenario;

                return $contact;
            }
        }

        if (!$createWhenNotExists) {
            return null;
        }

        /** @var Contact $model */
        $model = clone $originalContact;
        $model->setAttributes([
            'id' => null,
            'type' => 'localized',
            'localization' => $language,
        ]);

        return $model;
    }

    /**
     * Loads contract from the data array
     *
     * @param array $datum
     * @return bool
     */
    protected function loadContract($datum)
    {
        $contract = $this->getContract();

        return $contract->load($datum, '');
    }

    /**
     * Creates collection of contacts
     *
     * @return Collection
     */
    protected function getContactsCollection()
    {
        $collection = new Collection();
        $collection->set($this->contacts);

        return $collection;
    }
}
