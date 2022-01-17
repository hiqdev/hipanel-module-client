<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\tests\_support\Page\Widget\Input\Select2;

class DomainSettingsCest
{
    // todo: this test need to be moved to Domain module
    public function _before(Admin $I, $scenario): void
    {
        $scenario->skip('This test should to be moved to the Domain module');
    }

    /**
     * @dataProvider provideDomainSettings
     */
    public function ensureDomainSettingsWorksCorrectly(Admin $I, Example $example): void
    {
        $example = iterator_to_array($example->getIterator());
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));

        $I->see('Client detailed information', 'small');
        $I->see('Domain settings');
        $I->clickLink('Domain settings');

        $this->ensureDomainPopupWorksCorrectly($I, $example);
    }

    private function ensureDomainPopupWorksCorrectly(Admin $I, array $domainInformation): void
    {
        $I->waitForText('The settings will be automatically applied to all new registered domains.');

        $I->see('Default contacts:');
        $I->see($domainInformation['input'], 'label');

        foreach ($domainInformation['select2'] as $label) {
            $fieldId = strtolower(preg_replace('(\s\w+)', '', $label));

            $I->see($label, 'label');
            $I->seeElement((new Select2($I, "select[id*=$fieldId]"))->getSelector());
        }
    }

    protected function provideDomainSettings(): array
    {
        return [
            [
                'input' => 'Name servers',
                'select2' => [
                    'Registrant contact',
                    'Tech contact',
                    'Admin contact',
                    'Billing contact',
                ],
            ],
        ];
    }
}
