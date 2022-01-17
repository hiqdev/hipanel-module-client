<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Dropdown;

class FinancialSettingsCest
{
    public function _before(Admin $I): void
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
    }

    public function ensureISeeFinancialSettingsLink(Admin $I): void
    {
        $I->see('Client detailed information', 'small');
        $I->see('Financial settings');
    }

    /**
     * @dataProvider example
     */
    public function ensureFinancialSettingsPopupWorksCorrectly(Admin $I, Example $example): void
    {
        $exampleData = iterator_to_array($example->getIterator());
        $I->clickLink('Financial settings');
        $I->waitForText('Select the preferred currency for invoices');

        $I->waitForText('Select the preferred currency for invoices');

        $I->see('Financial emails', 'label');
        (new Input($I, "input[id*=finance_emails]"))->setValue($exampleData['email']);
        (new Dropdown($I, "select[id*=autoexchange_to]"))->setValue($exampleData['currency']);
        $I->checkOption("input[id*='autoexchange_enabled']");
        $I->checkOption("input[id*='autoexchange_prepayments']");

        $I->pressButton('Save');

        $I->waitForPageUpdate();
        $I->closeNotification('Settings saved');
        $I->clickLink('Financial settings');

        $I->waitForText('Select the preferred currency for invoices');

        $inputSelector = (new Input($I, "input[id*=finance_emails]"))->getSelector();
        $I->seeCheckboxIsChecked("input[id*='autoexchange_enabled']");
        $I->seeCheckboxIsChecked("input[id*='autoexchange_prepayments']");
        $I->seeInField($inputSelector, $exampleData['email']);
        $I->see($exampleData['currency']);
    }

    protected function example(): array
    {
        return [
            [
                'email' => 'testmail@hiqdev.com',
                'currency' => '€',
            ],
        ];
    }
}
