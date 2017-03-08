<?php

namespace hipanel\modules\client\forms;

use hipanel\base\Model;
use hipanel\modules\client\models\Contact;

class EmployeeForm extends Model
{
    public $languages = ['en', 'uk'];

    public function __construct(Contact $contact, array $config = [])
    {
        parent::__construct($config);

        $this->contact = $contact;
    }

    /**
     * @var Contact
     */
    public $contact;

    /**
     * @return Contact[]
     */
    public function getContactLocalizations()
    {
        $result = [];

        foreach ($this->languages as $language) {
            $result[$language] = $this->contact->getLocalized($language);
        }

        return $result;
    }
}

/*
 *
 */
