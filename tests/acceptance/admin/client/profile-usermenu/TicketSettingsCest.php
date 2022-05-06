<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use Codeception\Example;
use Codeception\Exception\ModuleException;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\tests\_support\Page\Widget\Input\Input;

class TicketSettingsCest
{
    /**
     * @throws ModuleException
     */
    public function _before(Admin $I): void
    {
        $I->login();

        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->clickLink('Ticket settings');
        $I->waitForText('In this field you can specify to receive email notifications of ticket');
    }

    /**
     * @dataProvider provideTicketSettings
     * @throws ModuleException
     */
    public function ensureTicketSettingsPopupFormWorksCorrectly(Admin $I, Example $example): void
    {
        $ticket = iterator_to_array($example->getIterator());

        foreach ($ticket['labels'] as $label) {
            $I->see($label, 'label');
        }
        foreach ($ticket['inputs'] as $fieldId => $value) {
            (new Input($I, "input[id*='$fieldId']"))->setValue($value);
        }
        foreach ($ticket['checkboxes'] as $checkbox) {
            $I->see($checkbox);
            $checkboxId = strtolower(preg_replace('(\s)', '_', $checkbox));
            $I->checkOption("input[id*='$checkboxId']");
        }

        $I->pressButton('Save');
        $I->waitForPageUpdate();
    }

    /**
     * @dataProvider provideTicketSettings
     */
    public function ensureTicketSettingsWereSaved(Admin $I, Example $example): void
    {
        $ticket = iterator_to_array($example->getIterator());

        foreach ($ticket['inputs'] as $fieldId => $value) {
            $I->seeInField("input[id*='$fieldId']", $value);
        }
        foreach ($ticket['checkboxes'] as $checkbox) {
            $checkboxId = strtolower(preg_replace('(\s)', '_', $checkbox));
            $I->seeCheckboxIsChecked("input[id*='$checkboxId']");
        }
    }

    protected function provideTicketSettings(): array
    {
        return [
            [
                'labels' => [
                    'Email for tickets',
                    'Allowed emails for creating tickets',
                ],
                'inputs' => [
                    'client-ticket_emails' => 'ticketEmail@hiqdev.com',
                ],
                'checkboxes' => [
                    'Send message text',
                    'New messages first',
                ],
            ],
        ];
    }
}
