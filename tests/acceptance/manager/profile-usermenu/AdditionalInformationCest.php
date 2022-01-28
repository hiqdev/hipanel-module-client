<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager\profile\usermenu;

use hipanel\helpers\Url;
use Codeception\Example;
use Codeception\Exception\ModuleException;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Step\Acceptance\Manager;
use hipanel\tests\_support\Page\Widget\Input\Dropdown;

class AdditionalInformationCest
{
    /**
     * @throws ModuleException
     */
    public function _before(Manager $I): void
    {
        $indexPage = new IndexPage($I);

        $I->login();
        $I->needPage(Url::to('@client'));

        $selector = $I->grabTextFrom($this->getSelector($indexPage)) === 'hipanel_test_manager' ?
            $this->getSelector($indexPage, 2) : $this->getSelector($indexPage);

        $I->click($selector);
        $I->waitForPageUpdate();
        $I->clickLink('Set additional information');
        $I->waitForElementVisible("//*[@id='set-attributes-form']/button[1]");
    }

    private function getSelector(IndexPage $indexPage, $tr = 1): ?string
    {
        $td = $indexPage->getColumnNumber('Login');

        return "//tbody//tr[$tr]//td[$td]//a[1]";
    }

    public function deleteAdditionalInformationIfExists(Manager $I): void
    {
        $rows = count($I->grabMultiple("//div[contains(@class, 'box box-solid')]
            //table[contains(@class, 'table table-striped')]//tr"));

        for (;$rows >= 1; $rows--) {
            $I->click("//div[contains(@class, 'modal-body')]/form //tbody//tr[last()] //button");
        }

        $this->saveAndCheckForSavedAdditionalInformation($I);
    }

    /**
     * @dataProvider provideAdditionalInformation
     */
    public function addAdditionalInformation(Manager $I, Example $example): void
    {
        $selector = "//div[contains(@class, 'modal-body')]/form//tbody//tr";

        $data = iterator_to_array($example->getIterator());

        foreach ($data as $key => $value) {
            (new Dropdown($I, $selector . '[last()]//select'))->setValue($key);
            (new Input($I, $selector . '[last()]//input'))->setValue($value);
            $I->click('//thead//button');
        }

        $this->saveAndCheckForSavedAdditionalInformation($I, $data);
    }

    private function saveAndCheckForSavedAdditionalInformation(Manager $I, array $data = NULL): void
    {
        $selector = "//table[contains(@class, 'table table-striped')]";
        $element = "//*[@id='set-attributes-form']/button[1]";

        $I->waitForElementVisible($element);
        $I->click($element);
        $I->closeNotification('Client was updated');

        if ($data === NULL) {
            $I->cantSee($selector . ' //td');
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
