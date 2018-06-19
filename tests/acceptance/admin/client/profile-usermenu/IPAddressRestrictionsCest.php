<?php

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class IPAddressRestrictionsCest
{
    /**
     * @var array
     */
    private $views;

    /**
     * @var array
     */
    private $testData;

    public function __construct()
    {
        $firstMessage = <<<MSG
Enter comma separated list of IP-addresses or subnets.
Example: 88.208.52.222, 213.174.0.0/16

Your current IP address is
MSG;
        $secondMessage = <<<MSG
All of accounts in the hosting panel will use following permit IP addresses list by default. 
You can reassign permitted IP addresses for each account individually in it's settings.
MSG;

        $this->views = [
            ['text' => $firstMessage,                              'selector' => '.modal-body'],
            ['text' => $secondMessage,                             'selector' => '.help-block'],
            ['text' => 'Allowed IPs for panel login',              'selector' => '.control-label'],
            ['text' => 'Default allowed IPs for SSH/FTP accounts', 'selector' => '.control-label'],
            ['text' => 'Save',                                     'selector' => '//button[@type="submit"]'],
            ['text' => 'Cancel',                                   'selector' => '//button[@type="button"]'],
        ];

        $this->testData = [
            'inputErrors' => [
                [
                    'name' => 'allowed_ips',
                    'text' => 'text',
                    'message' => 'Allowed IPs for panel login must be an IP address with specified subnet.',
                ],
                [
                    'name' => 'sshftp_ips',
                    'text' => 'text',
                    'message' => 'Default allowed IPs for SSH/FTP accounts must be an IP address with specified subnet.',
                ],
            ],
            'inputOk' => [
                [
                    'allowed_ips' => '0.0.0.0/0',
                    'sshftp_ips' => '0.0.0.0/0',
                ],
                [
                    'allowed_ips' => '',
                    'sshftp_ips' => '',
                ],
            ],
        ];

    }

    public function ensureThatIPAddressRestrictionsWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $this->testView($I);
        $this->testInputErrors($I);
        $this->testInput($I);
    }

    private function testView(Admin $I)
    {
        $I->click('IP address restrictions');
        $I->waitForElement('#ip-restrictions-form');
        foreach ($this->views as $element) {
            $I->see($element['text'], $element['selector']);
        }
        $I->click('Cancel');
    }

    private function testInputErrors(Admin $I)
    {
        $I->click('IP address restrictions');
        $I->waitForElement('#ip-restrictions-form');
        foreach ($this->testData['inputErrors'] as $input) {
            $I->fillField(['name' => "Client[{$I->id}][{$input['name']}]"], $input['text']);
            $I->click('Save');
            $I->waitForText($input['message']);
        }
        $I->click('Cancel');
    }

    private function testInput(Admin $I)
    {
        $I->click('IP address restrictions');
        $I->waitForElement('#ip-restrictions-form');
        foreach ($this->testData['inputOk'] as $input) {
            foreach ($input as $name => $value) {
                $I->fillField(['name' => "Client[{$I->id}][{$name}]"], $value);
            }
            $I->click('Save');
            $this->closePopup($I, 'Settings saved');
            $I->click('IP address restrictions');
            $I->waitForElement('#ip-restrictions-form');
            foreach ($input as $name => $value) {
                $I->seeInField("//input[@name='Client[{$I->id}][{$name}]']", $value);
            }
        }
        $I->click('Cancel');
    }

    private function closePopup(Admin $I, string $text)
    {
        $I->waitForElement('.ui-pnotify', 180);
        $I->see($text, '.ui-pnotify');
        $I->moveMouseOver(['css' => '.ui-pnotify']);
        $I->wait(1);
        $I->click('//span[@title="Close"]');
    }
}
