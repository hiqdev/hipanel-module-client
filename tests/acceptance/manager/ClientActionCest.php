<?php
declare(strict_types=1);
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
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\modules\client\tests\_support\Page\client\Create;
use hipanel\tests\_support\Step\Acceptance\Manager;

class ClientActionCest
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

        $existingLogin = $this->existingClient[0]['login'];
        $existingEmail = $this->existingClient[0]['email'];

        $page->fillClientData($this->existingClient[0]);
        $I->pressButton('Save');
        $page->seeTakenDataErrors($existingLogin, $existingEmail);
    }

    public function ensureDeleteByLoginsButtonWorksCorrectly(Manager $I): void
    {
        $I->needPage(Url::to('@client'));

        $I->clickLink('Delete by logins');

        $I->waitForText('Type client logins, delimited with a space, comma or a new line');

        $logins = '';
        foreach ($this->existingClient as $client) {
            $logins = $logins . $client['login'] . ' ';
        }

        (new Input($I, '#deleteclientsbyloginsform-logins'))->setValue($logins);

        $I->pressButton('Delete clients');
        $I->waitForPageUpdate();

        $this->ensureClientsWasDeleted($I, $logins);
    }

    private function ensureClientsWasDeleted(Manager $I, string $logins): void
    {
        $index = new IndexPage($I);
        $I->needPage(Url::to('@client'));

        $column = $index->getColumnNumber('Status');
        $logins = explode(" ", substr_replace($logins ,"", -1));
        foreach ($logins as $login) {
            $row = $index->getRowNumberInColumnByValue('Login', $login);
            $I->see('Deleted', "//tbody/tr[$row]/td[$column]");
        }
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
        $this->existingClient = $clientData;

        return $clientData;
    }
}
