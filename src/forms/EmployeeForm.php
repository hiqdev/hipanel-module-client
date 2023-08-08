<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\forms;

use hipanel\modules\client\actions\BankDetailsLoaderTrait;
use hipanel\modules\client\models\Contact;
use hipanel\modules\document\models\Document;
use hiqdev\hiart\Collection;
use hiqdev\hiart\ResponseErrorException;
use Yii;

/**
 * Class EmployeeForm represents form for employee management.
 */
class EmployeeForm
{
    use BankDetailsLoaderTrait;

    const DEFAULT_SCENARIO = 'default';
    /**
     * Default contact language.
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
    private ?string $error = null;
    private ?array $errorOPS = [];

    /**
     * @param Contact $contact
     * @param string|null $scenario
     */
    public function __construct(Contact $contact, ?string $scenario)
    {
        $this->scenario = $scenario ?? self::DEFAULT_SCENARIO;
        $this->contacts = $this->extractContacts($contact);
        if (Yii::$app->user->can('document.read')) {
            $this->contract = $this->extractContract($contact);
        }
    }

    /**
     * Extracts all the contacts available in the $contact model.
     *
     * @param Contact $contact
     * @return array
     */
    protected function extractContacts(Contact $contact): array
    {
        $result = [];

        foreach ($this->languages as $language) {
            $result[$language] = $this->contactLocalization($contact, $language);
        }

        return $result;
    }

    /**
     * Extracts contract out of documents array.
     *
     * @param Contact $contact
     * @return Document|null
     */
    protected function extractContract(Contact $contact): ?Document
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
    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function getName(): string
    {
        return $this->getPrimaryContact()->getName();
    }

    /**
     * Returns primary contact.
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
     * @return Contact|null
     */
    public function getContact(string $localization): ?Contact
    {
        return $this->contacts[$localization] ?? null;
    }

    /**
     * @param array $data
     * @return bool whether data was loaded successfully
     */
    public function load($data)
    {
        if ($contacts = $data['Contact']) {
            $this->loadContacts($contacts, (string)$data['pincode']);
        }

        if ($contract = $data['Document']) {
            $this->loadContract($contract);
        }

        $this->loadBankDetailsToLoadedContacts($data);

        return true;
    }

    public function getContract(): ?Document
    {
        return $this->contract;
    }

    public function validate(): bool
    {
        $contacts = $this->getContactsCollection();
        if (!$contacts->validate()) {
            $this->error = $contacts->getFirstError();
        }

        if ($this->getContract() !== null) {
            if (!$this->getContract()->validate()) {
                $errors = $this->getContract()->getFirstErrors();

                $this->error = reset($errors);
            }
        }

        return $this->error === null;
    }

    public function save(): bool
    {
        $collection = $this->getContactsCollection();

        try {
            $contractSaved = true;
            $contactsSaved = $collection->save();

            if ($this->getContract() !== null) {
                $contractSaved = $this->getContract()->save();
            }

            return $contactsSaved && $contractSaved;
        } catch (ResponseErrorException $e) {
            $this->error = $e->getMessage();
            $this->errorOPS = $e->getResponse()->getData()['_error_ops'] ?? null;
        }

        return false;
    }

    /**
     * Returns fields available for editing in the contract information.
     *
     * @return array
     */
    public function getContractFields(): array
    {
        return [
            'no' => Yii::t('hipanel:client', 'Number'),
            'date' => Yii::t('hipanel:client', 'Date'),
            'provided_services_en' => Yii::t('hipanel:client', 'Provided services (en)'),
            'provided_services_uk' => Yii::t('hipanel:client', 'Provided services (uk)'),
        ];
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function getErrorOPS(): ?array
    {
        return $this->errorOPS;
    }

    /**
     * Loads contact from the $data array.
     * Sets $pincode to each model.
     *
     * @param array $data
     * @param string $pinCode
     * @return bool whether data was loaded successfully
     */
    protected function loadContacts(array $data, string $pinCode): bool
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

            $contact->pincode = $pinCode;
        }

        return $success;
    }

    /**
     * Gets localized version of this contact.
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
     * Loads contract from the data array.
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
     * Creates collection of contacts.
     *
     * @return Collection
     */
    protected function getContactsCollection(): Collection
    {
        $collection = new Collection();
        $collection->set($this->contacts);

        return $collection;
    }

    private function loadBankDetailsToLoadedContacts(array $data): void
    {
        $contacts = $this->contacts;
        $bankDetails = $this->extractBankDetails($data);
        foreach ($contacts as $contact) {
            $contactBankDetails = array_filter(
                $bankDetails,
                static fn($model) => (string)$model['requisite_id'] === (string)$contact->id
            );
            $contactBankDetails = array_values($contactBankDetails); // reset keys, if `no` attribute does not exist then order matters
            $contact->setBankDetails = $contactBankDetails;
        }
        $this->contacts = $contacts;
    }
}
