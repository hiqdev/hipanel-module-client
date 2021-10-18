<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\_support\Page\client;

use Codeception\Example;
use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\Widget\Input\Select2;

class Create extends Authenticated
{
    /**
     * @param Example/array $clientData
     * @throws \Exception
     */
    public function fillClientData($clientData): void
    {
        $I = $this->tester;

        $I->fillField(['name' => 'Client[0][login]'], $clientData['login']);
        $I->fillField(['name' => 'Client[0][email]'], $clientData['email']);
        $I->fillField(['name' => 'Client[0][password]'], $clientData['password']);
        $I->selectOption('#client-0-type', ['value' => $clientData['type']]);

        foreach (['referer', 'reseller'] as $fieldName) {
            if (!is_null($clientData[$fieldName])) {
                (new Select2($I, "#client-0-${fieldName}_id"))
                    ->setValue($clientData[$fieldName]);
            }
        }
    }

    /**
     * Checks whether the client was successfully created.
     *
     * @param string $login
     * @param string $type
     * @throws \Exception
     */
    public function seeClientWasCreated(string $login, string $type): void
    {
        $I = $this->tester;

        $I->closeNotification('Client was created');
        $I->seeInCurrentUrl('/client/view?id=');
        $I->see($login);

        $I->see($type, 'th[data-resizable-column-id="type"] +  td > *');
    }

    /**
     * Checks whether the blank field error appear.
     *
     * @throws \Exception
     */
    public function seeBlankFieldErrors(): void
    {
        $I = $this->tester;

        $fieldsForCheck = ['Email', 'Password'];

        foreach ($fieldsForCheck as $field) {
            $I->waitForText("{$field} cannot be blank.");
        }
    }

    /**
     * Checks whether the taken field error appear.
     *
     * @param string $existingLogin
     * @param string $existingEmail
     * @throws \Exception
     */
    public function seeTakenDataErrors(
        string $existingLogin,
        string $existingEmail
    ): void {
        $I = $this->tester;

        $I->waitForText("Login \"$existingLogin\" has already been taken.", 30);
        $I->waitForText("Email \"$existingEmail\" has already been taken.", 30);
    }
}
