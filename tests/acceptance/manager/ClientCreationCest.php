<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\manager;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\modules\client\tests\_support\Page\client\Create;
use hipanel\tests\_support\Step\Acceptance\Manager;

class ClientCreationCest
{
    private $existingClient;

    public function ensureClientCreationPageWorks(Manager $I): void
    {
        $I->login();
        $I->needPage(Url::to('@client/create'));
    }

    /**
     * Tries to create a new client and expects for the successful creation.
     *
     * @dataProvider provideValidClientData
     * @param Manager $I
     * @param Example $clientData
     * @throws \Exception
     */
    public function ensureICanCreateNewClient(Manager $I, Example $clientData): void
    {
        $page = new Create($I);

        $I->needPage(Url::to('@client/create'));

        $page->fillClientData($clientData);
        $I->pressButton('Save');
        $I->waitForPageUpdate();
        $page->seeClientWasCreated($clientData['login'], $clientData['type']);
    }

    /**
     * Tries to create a new client and expects for the error due blank field.
     *
     * @param Manager $I
     * @throws \Exception
     */
    public function ensureICantCreateClientWithoutAllRequiredData(Manager $I): void
    {
        $page = new Create($I);

        $I->needPage(Url::to('@client/create'));
        $I->pressButton('Save');

        $page->seeBlankFieldErrors();
    }

    /**
     * Tries to create a new client and expects for the error due taken value.
     *
     * @param Manager $I
     * @throws \Exception
     */
    public function ensureICantCreateClientWithTakenData(Manager $I): void
    {
        $page = new Create($I);

        $I->needPage(Url::to('@client/create'));

        $existingLogin = $this->existingClient['login'];
        $existingEmail = $this->existingClient['email'];

        $page->fillClientData($this->existingClient);
        $I->pressButton('Save');
        $page->seeTakenDataErrors($existingLogin, $existingEmail);
    }

    /**
     * Returns array of valid information for each type of client.
     *
     * @return array
     */
    protected function provideValidClientData(): array
    {
        $clientData = [];

        foreach (['client', 'reseller', 'manager', 'admin', 'support'] as $type) {
            $clientData[] = [
                'login'     => 'test_login' . uniqid(),
                'email'     => 'test_email@test.test' . uniqid(),
                'password'  => 'test_pass',
                'type'      =>  $type,
                'referer'   => null,
                'reseller'  => null,
            ];
        }
        $this->existingClient = $clientData[0];

        return $clientData;
    }
}
