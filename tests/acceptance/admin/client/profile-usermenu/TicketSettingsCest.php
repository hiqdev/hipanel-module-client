<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\tests\_support\Page\Widget\Input\Input;

class TicketSettingsCest
{
    /**
     * @dataProvider provideTicketSettings
     */
    public function ensureTicketSettingsWorksCorrectly(Admin $I, Example $example): void
    {
        $example = iterator_to_array($example->getIterator());
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));

        $I->see('Client detailed information', 'small');
        $I->see('Ticket settings');
        $I->clickLink('Ticket settings');

        $this->ensureTicketSettingsPopupWorksCorrectly($I, $example);
        $this->enusreTicketSettingsWereSaved($I, $example);
    }

    private function ensureTicketSettingsPopupWorksCorrectly(Admin $I, array $ticket): void
    {
        $I->waitForText('In this field you can specify to receive email notifications of ticket');

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
    }

    private function enusreTicketSettingsWereSaved(Admin $I, array $ticket): void
    {
        $I->waitForPageUpdate();
        $I->closeNotification('Settings saved');
        $I->clickLink('Ticket settings');

        $I->waitForText('In this field you can specify to receive email notifications of ticket');

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
                    'client-create_from_emails' => 'allowedEmail@hiqdev.com',
                ],
                'checkboxes' => [
                    'Send message text',
                    'New messages first',
                ],
            ],
        ];
    }
}
