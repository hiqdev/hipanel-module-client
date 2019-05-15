<?php

namespace hipanel\modules\client\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\modules\client\tests\_support\Page\contact\Create;
use hipanel\modules\client\tests\_support\Page\contact\Index;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ContactsCest
{
    /**
     * @var Index $index
     */
    private $index;
    /**
     * @var Create $create
     */
    private $create;
    /**
     * @var string $contactId
     */
    private $contactId;

    public function _before(Admin $I): void
    {
        $this->index = new Index($I);
        $this->create = new Create($I);
    }

    public function ensureIndexPageWorks(Admin $I): void
    {
        $I->needPage(Url::to('@contact'));
        $I->see('Contact', 'h1');
        $I->seeLink('Create', Url::to('create'));
        $this->index->ensureICanSeeAdvancedSearchBox($I);
        $this->index->ensureICanSeeBulkSearchBox();
    }

    public function ensureICanCreateContact(Admin $I): void
    {
        $I->needPage(Url::to('@contact/create'));
        $I->see('Create contact', 'h1');
        $testContact = $this->testContactData();
        $this->create->fillFormData($testContact);
        $I->click('Create contact');
        $this->contactId = $this->create->seeContactWasCreated();
    }

    public function ensureICantCreateIncorrectContact(Admin $I): void
    {
        $I->needPage(Url::to('@contact/create'));
        $testContact = $this->testContactData();
        $testContact['inputs']['street1'] = '111111111111111111111111111111111111111111111111111111111111111';
        $testContact['inputs']['street2'] = '111111111111111111111111111111111111111111111111111111111111111';
        $testContact['inputs']['street3'] = '111111111111111111111111111111111111111111111111111111111111111';
        $this->create->fillFormData($testContact);
        $I->click('Create contact');
        $this->create->seeErrorInAddress();
    }

    public function ensureICanDeleteContact(Admin $I): void
    {
        $testContact = $this->testContactData()['inputs'];
        $I->needPage(Url::to('@contact/index'));
        $this->index->showCreatedContactOnIndexPage($testContact['first_name']);
        $this->index->checkBoxClick((string)$this->contactId);
        $I->click('Delete');
        $I->acceptPopup();
        $I->waitForPageUpdate();
        $I->closeNotification('Contact was deleted');
    }

    /**
     * @return array
     */
    private function testContactData(): array
    {
        return [
            'inputs' => [
                'first_name'    => 'Test',
                'last_name'     => 'Admin',
                'email'         => 'hipanel_test_manager@hiqdev.com',
                'abuse_email'   => 'hipanel_test_manager+abuse@hiqdev.com',
                'organization'  => 'HiQDev',
                'street1'       => 'Test address',
                'city'          => 'Test',
                'province'      => 'Testing',
                'postal_code'   => 'TEST',
                'voice_phone'   => '(445) 456-4561',
                'icq'           => '1002893',
                'skype'         => 'hipanel_test_manager',
                'jabber'        => 'hipanel_test_manager@hiqdev.com',
                'telegram'      => 'hipanel_test_manager',
                'whatsapp'      => '123456789012',
                'social_net'    => 'https://facebook.com/hipanel_test_manager',
            ],
            'selects' => [
                'country'       => 'Algeria',
                'client'        => 'hipanel_test_admin',
            ],

        ];
    }
}
