<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;

class NotificationSettingsCest
{
    /**
     * @dataProvider provideNotification
     */
    public function ensureNotificationSettingsWorksCorrectly(Admin $I, Example $example): void
    {
        $example = iterator_to_array($example->getIterator());
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));

        $I->see('Client detailed information', 'small');
        $I->see('Notification settings');
        $I->clickLink('Notification settings');

        $this->ensureNotificationPopupWorksCorrectly($I, $example);
    }

    private function ensureNotificationPopupWorksCorrectly(Admin $I, array $notifications): void
    {
        $selector = "//div[@class='modal-body']/form";
        $I->waitForText('System notifications');

        $I->see('Mailings');

        foreach ($notifications as $notification) {
            $I->see($notification, $selector);
        }
    }

    protected function provideNotification(): array
    {
        return [
            [
                'Notify important actions',
                'Domain registration',
                'Payment notification',
                'Newsletters',
                'Commercial',
            ],
        ];
    }
}
