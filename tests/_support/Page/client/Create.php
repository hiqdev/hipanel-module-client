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
use hipanel\helpers\Url;
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
        $this->fillClientDataReliably($clientData);
    }

    /**
     * fillField() occasionally doesn't stick on this exact form on a 2nd+ visit to
     * this page within the same browser session (confirmed live: not a page bug,
     * a ChromeDriver/sendKeys flake - the field stays focused and reports success,
     * but its DOM value ends up empty). `restart: true` on the WebDriver module
     * fixes this between separate Codeception tests (a fresh browser each time),
     * but ensureICantCreateClientWithTakenData() revisits this same page from
     * *within* a single test, after a real creation already happened - so this
     * fallback still matters there.
     *
     * A plain page reload does NOT fix it - confirmed live with up to 8 reload
     * attempts in the same session, all still empty. Only a full browser restart
     * (a genuinely new WebDriver session, matching what restart: true itself does
     * between tests) reliably works, so that's the fallback here, re-logging in
     * via the actor's own login() (which restores the saved session cookies
     * rather than doing a real interactive login again).
     *
     * @param array $clientData
     */
    private function fillClientDataReliably($clientData, int $attempts = 3): void
    {
        $I = $this->tester;

        for ($attempt = 1; $attempt <= $attempts; $attempt++) {
            $I->waitForElement(['name' => 'Client[0][login]']);
            $I->fillField(['name' => 'Client[0][login]'], $clientData['login']);
            $I->fillField(['name' => 'Client[0][email]'], $clientData['email']);
            $I->fillField(['name' => 'Client[0][password]'], $clientData['password']);

            if ($I->grabValueFrom(['name' => 'Client[0][login]']) === $clientData['login']
                && $I->grabValueFrom(['name' => 'Client[0][email]']) === $clientData['email']
                && $I->grabValueFrom(['name' => 'Client[0][password]']) === $clientData['password']
            ) {
                $I->selectOption('#client-0-type', ['value' => $clientData['type']]);

                foreach (['referer', 'reseller'] as $fieldName) {
                    if (!is_null($clientData[$fieldName])) {
                        (new Select2($I, "#client-0-${fieldName}_id"))
                            ->setValue($clientData[$fieldName]);
                    }
                }

                return;
            }

            if ($attempt < $attempts) {
                $I->restartBrowser();
                $I->login();
                $I->amOnPage(Url::to('@client/create'));
                $I->waitPageLoad();
            }
        }

        throw new \RuntimeException("Could not fill the client form after {$attempts} attempts (browser restart + refill each time)");
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

        $I->waitForText("Login \"$existingLogin\" has already been taken.");
        $I->waitForText("Email \"$existingEmail\" has already been taken.");
    }
}
