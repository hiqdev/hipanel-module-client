<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Manager;
use hipanel\tests\_support\Page\Widget\Input\Dropdown;
use hipanel\tests\_support\Page\Widget\Input\Input;

class ClientBulkEditCest
{
    public function ensureICanDoBulkActionSeveralClients(Manager $I): void
    {
        $I->login();

        $I->needPage(Url::to('@client'));
        $selector = "//table[contains(@class, 'striped')]//tbody";

        $clients = $this->checkIfClientsCanBeDeleted($I, array(1, 2, 3), $selector);
        $this->ensureICanDoBulkActionOnSelectedUsers($I, $clients, $selector);
    }

    private function ensureICanDoBulkActionOnSelectedUsers(Manager $I, array $clients, string $baseSelector): void
    {
        $this->checkOptions($I, $clients, $baseSelector);
        $this->ensureICanEditSelectedUsers($I, $clients);
        $this->ensureUsersWereSuccessfullyEdited($I, $clients, $baseSelector);
    }

    private function checkOptions(Manager $I, array $clients, $baseSelector): void
    {
        foreach ($clients as $client) {
            $selector = "//tr[$client]//td[1]//input";
            $I->checkOption($baseSelector . $selector);
        }
    }

    private function ensureICanEditSelectedUsers(Manager $I, array $clients): void
    {
        $I->pressButton('Edit');
        $I->waitForPageUpdate();

        $I->seeInCurrentUrl('client/update');
        foreach ($clients as $key => $client) {
            (new Dropdown($I, "#client-$key-type"))->setValue('Partner');
        }

        $I->pressButton('Save');
        $I->waitForPageUpdate();
    }

    private function ensureUsersWereSuccessfullyEdited(Manager $I, array $clients, $baseSelector): void
    {
        $indexPage = new IndexPage($I);
        $I->seeInCurrentUrl('client/client');

        $row = $indexPage->getColumnNumber('Type');

        foreach ($clients as $client) {
            $I->see('Partner' , $baseSelector . "//tr[$client]//td[$row]");
        }
    }

    private function ensureICanBlockSelectedUsers(Manager $I): void
    {
        $I->pressButton('Basic actions');
        $I->clickLink('Enable block');
        $I->waitForText('Affected clients', 30);

        (new Input($I, 'enable-block-comment'))->setValue('NaN');
        $I->pressButton('Enable block');
    }

    private function checkIfClientsCanBeDeleted(Manager $I, array $clients, string $selector): array
    {
        $indexPage = new IndexPage($I);
        $restrictedLogins = array('hipanel_test_user', 'hipanel_test_reseller', 'hipanel_test_manager', 'hipanel_test_admin');

        $row = $indexPage->getColumnNumber('Login');

        $availableLogins = true;
        while ($availableLogins) {
            foreach ($clients as $key => $client) {
                $login = $I->grabTextFrom($selector . "//tr[$client]" . "//td[$row]//a[1]");
                foreach ($restrictedLogins as $restricteLogin) {
                    if (!strcmp($login, $restricteLogin)) {
                        $clients[$key] += 3;
                        $availableLogins = true;
                        break;
                    }
                    $availableLogins = false;
                }
                if ($availableLogins) break;
            }
        }
        return $clients;
    }
}
