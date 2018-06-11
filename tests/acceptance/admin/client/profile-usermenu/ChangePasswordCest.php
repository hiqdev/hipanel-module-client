<?php

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class ChangePasswordCest
{
    private $warningSelector = '//label[@class="control-label"]/../p';
    private $labels = [];

    public function ensureThatChangePasswordWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->click('Change password');
        $I->waitForElement('#change-password-form');
        $this->labels = [
            ['text' => 'Login',            'warning' => ''],
            ['text' => 'Current password', 'warning' => 'cannot be blank.'],
            ['text' => 'New password',     'warning' => 'cannot be blank.'],
            ['text' => 'Confirm password', 'warning' => 'cannot be blank.'],
        ];

        $this->testVisibility($I);
        $this->testWarnings($I);
        $this->testShowPasswordButton($I);
        $this->testDropDownMenu($I);

        $I->click('Cancel');
        $I->seeCurrentUrlEquals(Url::to(['@client/view', 'id' => $I->id]));
    }

    private function testVisibility(Admin $I)
    {
        $labelSelector = '//label[@class="control-label"]';

        foreach ($this->labels as $label) {
            $I->see($label['text'], $labelSelector);
        }
    }

    private function testWarnings(Admin $I)
    {
        $I->click('Save');
        $I->waitForText('cannot be blank.');

        foreach ($this->labels as $label) {
            if ($label['warning'] !== '') {
                $I->see("{$label['text']} {$label['warning']}", $this->warningSelector);
            }
        }

        $oldPassword = '0';
        $newPassword = 'NVc27ruX';

        $I->fillField("#client-{$I->id}-old_password", $oldPassword);
        $I->fillField("#client-{$I->id}-new_password", $newPassword);
        $I->fillField("#client-{$I->id}-confirm_password", $oldPassword);
        $I->click('Save');
        $I->waitForText('incorrect');
        $I->see('The password is incorrect', $this->warningSelector);
        $I->see('Confirm password must be equal to "New password".', $this->warningSelector);
    }

    private function testShowPasswordButton(Admin $I)
    {
        $I->click(['css' => '.show-password']);
        $I->waitForElement('//span[contains(@class, "glyphicon-eye-close")]');
        $I->click(['css' => '.show-password']);
        $I->waitForElement('//span[contains(@class, "glyphicon-eye-open")]');
    }

    private function testDropDownMenu(Admin $I)
    {
        $I->click('Random');
        $I->waitForElement('//button[@aria-expanded="true"]');
        $I->see('Weak', '//ul[@class="dropdown-menu"]/li/a[@class="random-passgen"]');
        $I->see('Medium', '//ul[@class="dropdown-menu"]/li/a[@class="random-passgen"]');
        $I->see('Strong', '//ul[@class="dropdown-menu"]/li/a[@class="random-passgen"]');
    }
}
