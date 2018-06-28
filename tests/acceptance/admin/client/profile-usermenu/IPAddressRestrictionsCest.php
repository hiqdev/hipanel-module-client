<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;

class IPAddressRestrictionsCest
{
    /**
     * @param Admin $I
     */
    public function _before(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
    }

    /**
     * @param Admin $I
     * @throws \Exception
     */
    private function openForm(Admin $I)
    {
        $I->click('IP address restrictions');
        $I->waitForElement('#ip-restrictions-form');
    }

    /**
     * @param Admin $I
     */
    private function closeForm(Admin $I)
    {
        $I->click('Cancel');
    }

    /**
     * @before openForm
     * @after closeForm
     * @param Admin $I
     */
    public function testVisibleModalElements(Admin $I)
    {
        $examples = $this->visibleModalElementsProvider();
        foreach ($examples as $example) {
            $I->see($example['text'], $example['selector']);
        }
    }

    /**
     * @return array
     */
    private function visibleModalElementsProvider()
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

        return [
            ['text' => $firstMessage,                              'selector' => '.modal-body'],
            ['text' => $secondMessage,                             'selector' => '.help-block'],
            ['text' => 'Allowed IPs for panel login',              'selector' => '.control-label'],
            ['text' => 'Default allowed IPs for SSH/FTP accounts', 'selector' => '.control-label'],
            ['text' => 'Save',                                     'selector' => '//button[@type="submit"]'],
            ['text' => 'Cancel',                                   'selector' => '//button[@type="button"]'],
        ];
    }

    /**
     * @before openForm
     * @after closeForm
     * @param Admin $I
     */
    public function testInvalidInputs(Admin $I)
    {
        $examples = $this->invalidInputValues();
        foreach ($examples as $example) {
            $name = "Client[{$I->id}][{$example['name']}]";
            $I->fillField(['name' => $name], $example['text']);
            $I->clickWithLeftButton("//div[contains(@class, 'callout')]");
            $I->waitForJS("return $(\"[name='{$name}']\").parent().find('p.help-block-error').text() !== '';", 10);
            $I->see($example['message']);
            $I->fillField(['name' => $name], '');
            $I->clickWithLeftButton("//div[contains(@class, 'callout')]");
            $I->waitForJS("return $(\"[name='{$name}']\").parent().find('p.help-block-error').text() === '';", 10);
        }
    }

    /**
     * @return array
     */
    private function invalidInputValues()
    {
        return [
            [
                'name' => 'allowed_ips',
                'text' => 'text',
                'message' => 'Allowed IPs for panel login must be a valid IP address.',
            ],
            [
                'name' => 'sshftp_ips',
                'text' => 'text',
                'message' => 'Default allowed IPs for SSH/FTP accounts must be a valid IP address.',
            ],
            [
                'name' => 'allowed_ips',
                'text' => '255.255.255.255/33',
                'message' => 'Allowed IPs for panel login contains wrong subnet mask.',
            ],
            [
                'name' => 'sshftp_ips',
                'text' => '255.255.255.255/33',
                'message' => 'Default allowed IPs for SSH/FTP accounts contains wrong subnet mask.',
            ],
        ];
    }

    /**
     * @before openForm
     * @after closeForm
     * @param Admin $I
     * @throws \Exception
     */
    public function testValidInputs(Admin $I)
    {
        $examples = $this->validInputValues();
        foreach ($examples as $example) {
            foreach ($example as $name => $value) {
                $I->fillField(['name' => "Client[{$I->id}][{$name}]"],
                    $value !== '' ? ($value . ', 0.0.0.0/0') : $value);
            }
            $I->click('Save');
            $I->closeNotification('Settings saved');
            $this->openForm($I);
            foreach ($example as $name => $value) {
                $I->seeInField("//input[@name='Client[{$I->id}][{$name}]']",
                    $value !== '' ? ($value . ', 0.0.0.0/0') : $value);
            }
        }
    }

    /**
     * @return array
     */
    private function validInputValues()
    {
        return [
            ['allowed_ips' => '1.2.3.4',         'sshftp_ips' => '1.2.3.4'],
            ['allowed_ips' => '172.20.10.1',     'sshftp_ips' => '172.20.10.1'],
            ['allowed_ips' => '192.168.1.99/24', 'sshftp_ips' => '192.168.1.99/24'],
            ['allowed_ips' => '192.168.1.99/24', 'sshftp_ips' => ''],
            ['allowed_ips' => '',                'sshftp_ips' => '192.168.1.99/24'],
            ['allowed_ips' => '',                'sshftp_ips' => ''],
        ];
    }
}
