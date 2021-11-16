<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager\profile\usermenu;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Manager;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Dropdown;

class AdditionalInformationCest
{
    private function getSelector($tr = 1): ?string
    {
        $selector = "//tbody//tr[$tr]//td[2]//a[1]";

        return $selector;
    }

    /**
     * @dataProvider provideAdditionalInformation
     */
    public function ensureAdditionalInformationWorksCorrectly(Manager $I, Example $example): void
    {
        $indexPage = new IndexPage($I);

        $example = iterator_to_array($example->getIterator());
        $I->login();
        $I->needPage(Url::to('@client'));

        $I->see('Clients', 'h1');

        $username = $I->grabTextFrom($this->getSelector());
        $selector = $this->getSelector();

        if ($username === 'hipanel_test_manager') {
            $selector = $this->getSelector(2);
        }

        $I->click($selector);
        $I->waitForPageUpdate();

        $I->see('Client detailed information', 'small');
        $I->clickLink('Set additional information');
        $I->waitForElementVisible("//button[contains(normalize-space(text()),'Confirm')]");

        $this->ensureAdditionalInformationPopupWorksCorrectly($I, $example);
    }

    private function ensureAdditionalInformationPopupWorksCorrectly(Manager $I, array $data): void
    {
        $formSelector = "//div[contains(@class, 'modal-body')]/form";
        $tableSelector = "//tbody//tr";

        $this->deleteAdditionalInformationIfExists($I, $formSelector . $tableSelector);
        $this->saveAndCheckForSavedAdditionalInformation($I);

        $I->clickLink('Set additional information');
        $I->waitForElementVisible("//button[contains(normalize-space(text()),'Confirm')]");

        $this->addAdditionalInformation($I, $data, $formSelector . $tableSelector . '[last()]');
        $this->saveAndCheckForSavedAdditionalInformation($I, $data);
    }

    private function deleteAdditionalInformationIfExists(Manager $I, string $selector): void
    {
        $rows = count($I->grabMultiple($selector));

        for (;$rows >= 1; $rows--) {
            $I->click("//div[contains(@class, 'modal-body')]/form //tbody//tr[last()] //button");
        }
    }

    private function addAdditionalInformation(Manager $I, array $data, string $selector): void
    {
        foreach ($data as $key => $value) {
            (new Dropdown($I, $selector . ' //select'))->setValue($key);
            (new Input($I, $selector . ' //input'))->setValue($value);
            $I->click('//thead//button');
        }
    }

    private function saveAndCheckForSavedAdditionalInformation(Manager $I, array $data = NULL): void
    {
        $selector = "//table[contains(@class, 'table table-striped')]";

        $I->pressButton('Confirm');
        $I->waitForPageUpdate();
        $I->closeNotification('Client was updated');

        if ($data === NULL) {
            $I->cantSee($selector . ' //td');

            return;
        } else {
            foreach ($data as $row => $value) {
                $I->see($row, $selector . ' //td[1]');
                $I->see($value, $selector . ' //td[2]');
            }
        }
    }

    protected function provideAdditionalInformation(): array
    {
        return [
            [
            'Special Conditions'      => 'test_string #'. uniqid(),
            'Rent'                    => 'test_string #'. uniqid(),
            'Buyout'                  => 'test_string #'. uniqid(),
            'Buyout by installment'   => 'test_string #'. uniqid(),
            'Support service'         => 'test_string #'. uniqid(),
            'IP-addresses'            => 'test_string #'. uniqid(),
            'Rack'                    => 'test_string #'. uniqid(),
            'Network'                 => 'test_string #'. uniqid(),
            'vCDN'                    => 'test_string #'. uniqid(),
            'aCDN'                    => 'test_string #'. uniqid(),
            'Other information/Links' => 'test_string #'. uniqid(),
            ],
        ];
    }
}
