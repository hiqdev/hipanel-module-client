<?php

namespace hipanel\modules\client\tests\_support\Page\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\AcceptanceTester;
use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\Widget\Select2;


class Create extends Authenticated
{
    protected $select2;

    public function __construct(AcceptanceTester $I)
    {
        parent::__construct($I);

        $this->select2 = new Select2($I);
    }

    /**
     * Tries to create a new client and expects for the successful creation
     *
     * @param $clientData
     * @throws \Exception
     */
    public function createValidClient($clientData): void
    {
        $this->createClient($clientData);

        $this->seeClientWasCreated($clientData['login'], $clientData['type']);
    }

    /**
     * Tries to create a new client and expects for the error due blank field
     *
     * @throws \Exception
     */
    public function createEmptyDataClient(): void
    {
        $I = $this->tester;

        $I->needPage(Url::to('@client/create'));
        $I->click('Save', '#client-form');

        $this->seeClientWasNotCreatedDueBlank();
    }


    /**
     * Tries to create a new client and expects for the error due taken value
     *
     * @param $clientData
     * @throws \Exception
     */
    public function createExistingClient($clientData)
    {
        $existingLogin = $clientData['login'];
        $existingEmail = $clientData['email'];

        $this->createClient($clientData);

        $this->seeClientWasNotCreatedDueTaken($existingLogin, $existingEmail);
    }

    /**
     * Creates a new client
     *
     * @param $clientData
     */
    protected function createClient($clientData): void
    {
        $I = $this->tester;

        $I->needPage(Url::to('@client/create'));

        $I->fillField(['name' => 'Client[0][login]'], $clientData['login']);
        $I->fillField(['name' => 'Client[0][email]'], $clientData['email']);
        $I->fillField(['name' => 'Client[0][password]'], $clientData['password']);


        $I->selectOption('#client-0-type', ['value' => $clientData['type']]);

        $this->select2->open('#client-0-referer_id');
        $this->select2->fillSearchField($clientData['referer']);
        $this->select2->chooseOption($clientData['referer']);

        $this->select2->open('#client-0-seller_id');
        $this->select2->fillSearchField($clientData['reseller']);
        $this->select2->chooseOption($clientData['reseller']);

        $I->click('Save', '#client-form');
    }

    /**
     * Checks whether the client was successfully created
     *
     * @param string $login
     * @param string $type
     * @throws \Exception
     */
    protected function seeClientWasCreated(string $login, string $type): void
    {
        $I = $this->tester;

        $I->closeNotification('Client was created');
        $I->seeInCurrentUrl('/client/view?id=');
        $I->see($login);

        $I->see($type, 'th[data-resizable-column-id="type"] +  td > *');
    }

    /**
     * Checks whether the blank field error appear
     *
     * @throws \Exception
     */
    protected function seeClientWasNotCreatedDueBlank(): void
    {
        $I = $this->tester;

        $fieldsForCheck = ['Login', 'Email', 'Password'];

        foreach ($fieldsForCheck as $field) {
            $I->waitForText("{$field} cannot be blank.");
        }
    }

    /**
     * Checks whether the taken field error appear
     *
     * @param string $existingLogin
     * @param string $existingEmail
     * @throws \Exception
     */
    protected function seeClientWasNotCreatedDueTaken(
        string $existingLogin,
        string $existingEmail
    ): void {
        $I = $this->tester;

        $I->waitForText("Login \"$existingLogin\" has already been taken.");
        $I->waitForText("Email \"$existingEmail\" has already been taken.");
    }
}