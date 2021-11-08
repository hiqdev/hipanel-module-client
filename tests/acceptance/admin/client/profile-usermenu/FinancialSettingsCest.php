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
    /**
     * @dataProvider provideFinancialSettings
     */
    public function ensureFinancialSettingsWorksCorrectly(Admin $I, Example $example): void
    {
        $example = iterator_to_array($example->getIterator());
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));

        $I->see('Client detailed information', 'small');
        $I->see('Financial settings');
        $I->clickLink('Financial settings');

        $this->ensureFinancialSettingsPopupWorksCorrectly($I, $example);
        $this->enusreFinancialSettingsWereSaved($I, $example);
    }

    private function ensureFinancialSettingsPopupWorksCorrectly(Admin $I, array $financial): void
    {
        $I->waitForText('Select the preferred currency for invoicer');

        $I->see('Financial emails', 'label');
        (new Input($I, "input[id*=finance_emails]"))->setValue($financial['email']);
        (new Dropdown($I, "select[id*=autoexchange_to]"))->setValue($financial['currency']);
        $I->checkOption("input[id*='autoexchange_enabled']");
        $I->checkOption("input[id*='autoexchange_prepayments']");

        $I->pressButton('Save');
    }

    private function enusreFinancialSettingsWereSaved(Admin $I, array $financial): void
    {
        $I->waitForPageUpdate();
        $I->closeNotification('Settings saved');
        $I->clickLink('Financial settings');

        $I->waitForText('Select the preferred currency for invoices');

        $inputSelector = (new Input($I, "input[id*=finance_emails]"))->getSelector();
        $I->seeCheckboxIsChecked("input[id*='autoexchange_enabled']");
        $I->seeCheckboxIsChecked("input[id*='autoexchange_prepayments']");
        $I->seeInField($inputSelector, $financial['email']);
        $I->see($financial['currency']);
    }

    protected function provideFinancialSettings(): array
    {
        return [
            [
                'email'    => 'testmail@hiqdev.com',
                'currency' => '€',
            ],
        ];
    }
}
