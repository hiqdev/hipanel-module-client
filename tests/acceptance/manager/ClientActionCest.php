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
use hipanel\modules\client\tests\_support\Helper\UserCreationHelper;
use hipanel\tests\_support\Step\Acceptance\Manager;

class ClientActionCest
{
    private UserCreationHelper $userCreationHelper;

    protected function _inject(UserCreationHelper $userCreationHelper): void
    {
        $this->userCreationHelper = $userCreationHelper;
    }

    public function _before(Manager $I, $scenario): void
    {
        if (!$this->userCreationHelper->canCreateUsers()) {
            $scenario->skip($this->userCreationHelper->getDisabledMessage());
        }
    }

    public function ensureClientCreationPageWorks(Manager $I): void
    {
        $I->login();
        $I->needPage(Url::to('@client/index'));
        $createButtonSelector = "//a[normalize-space(.)='Create client'][contains(@class, 'btn-success')]";
        $I->seeElement($createButtonSelector);
        $I->click($createButtonSelector);
        $I->waitForPageUpdate();
        $I->seeElement("//h1[normalize-space(.)='Create client']");
    }

    /**
     * Tries to create a new client and expects for the successful creation.
     *
     * @dataProvider provideValidClientData
     * @param Manager $I
     * @param Example $clientData
     * @throws \Exception
     */
    public function ensureICanCreateAndDeleteNewClient(Manager $I, Example $clientData): void
    {
        $page = new Create($I);
        $clientData = iterator_to_array($clientData->getIterator());

        if (!isset($clientData['login'])) {
            $this->ensureDeleteByLoginsButtonWorksCorrectly($I, $clientData);
            return;
        }


        $I->needPage(Url::to('@client/create'));

        $page->fillClientData($clientData);
        $I->pressButton('Save');
        $I->waitForPageUpdate();
        $page->seeClientWasCreated($clientData['login'], $clientData['type']);
        $this->ensureICantCreateClientWithTakenData($I, $clientData);
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
    private function ensureICantCreateClientWithTakenData(Manager $I, array $client): void
    {
        $page = new Create($I);

        $I->needPage(Url::to('@client/create'));

        $page->fillClientData($client);
        $I->pressButton('Save');
        $page->seeTakenDataErrors($client['login'], $client['email']);
    }

    private function ensureDeleteByLoginsButtonWorksCorrectly(Manager $I, array $client): void
    {
        $I->needPage(Url::to('@client'));

        $I->pressButton('Delete by logins');

        $I->waitForText('Type client logins, delimited with a space, comma or a new line');

        $usernames = implode(' ', $client);
        (new Input($I, '#deleteclientsbyloginsform-logins'))->setValue($usernames);

        $I->pressButton('Delete clients');
        $I->waitForPageUpdate();
        $I->wait(5);

        foreach ($client as $username) {
            $this->ensureClientsWasDeleted($I, $username);
        }
    }

    private function ensureClientsWasDeleted(Manager $I, string $login): void
    {
        $index = new IndexPage($I);
        $I->needPage(Url::to('@client'));

        $column = $index->getColumnNumber('Status');
        $row = $index->getRowNumberInColumnByValue('Login', $login);
        $I->see('Deleted', "//tbody/tr[$row]/td[$column]");
    }

    /**
     * Returns array of valid information for each type of client.
     *
     * @return array
     */
    protected function provideValidClientData(): iterable
    {
        foreach (['client', 'reseller', 'manager', 'admin', 'support'] as $type) {
            $id = uniqid();
            yield [
                'login'     => $usernames[] = 'test_login' . $id,
                'email'     => 'test_email@test.test' . $id,
                'password'  => 'test_pass',
                'type'      =>  $type,
                'referer'   => null,
                'reseller'  => null,
            ];
        }
        yield $usernames;
    }
}
