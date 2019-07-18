<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\seller;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\modules\client\tests\_support\Page\contact\Create;
use hipanel\modules\client\tests\_support\Page\contact\Update;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ContactsCest
{
    /** @var IndexPage */
    private $indexPage;

    /** @var Create */
    private $createPage;

    /** @var array */
    private $createdContacts;

    public function _before(Seller $I): void
    {
        $this->indexPage = new IndexPage($I);
        $this->createPage = new Create($I);
    }

    /**
     * @dataProvider testContactData
     *
     * @param Seller $I
     * @param Example $data
     * @throws \Exception
     */
    public function ensureICanCreateContact(Seller $I, Example $data): void
    {
        $I->needPage(Url::to('@contact/create'));
        $I->see('Create contact', 'h1');
        $this->createPage->fillFormData($data);
        $I->click('Create contact');
        $contactId = $this->createPage->seeContactWasCreated();
        $this->createdContacts[$contactId] = $data['inputs']['first_name'];
    }

    /**
     * @param Seller $I
     * @throws \Codeception\Exception\ModuleException
     */
//    public function ensureICanUpdateContact(Seller $I): void
//    {
//        $updatePage = new Update($I);
//
//        foreach ($this->createdContacts as $id => $name) {
//            $I->needPage(Url::to('@contact'));
//
//            $this->indexPage->gridView->filterBy(
//                Input::asTableFilter($I, 'Name'), $name
//            );
//            $this->indexPage->gridView->openRowMenuById($id);
//            $this->indexPage->gridView->chooseRowMenuOption('Edit');
//
//            $data['inputs']['last_name'] = 'edited';
//            $updatePage->fillFormData($data);
//            $I->pressButton('Save');
//            $I->closeNotification('Contact was updated');
//        }
//    }

    /**
     * @param Seller $I
     * @throws \Exception
     */
    public function ensureICantCreateIncorrectContact(Seller $I): void
    {
        $I->needPage(Url::to('@contact/create'));
        $testContact = $this->testContactData()[0];
        $testContact['inputs']['street1'] = str_repeat('1', 65);
        $testContact['inputs']['street2'] = str_repeat('2', 65);
        $testContact['inputs']['street3'] = str_repeat('3', 65);
        $this->createPage->fillFormData($testContact);
        $I->click('Create contact');
        $this->createPage->seeErrorInAddress();
    }

    /**
     * @param Seller $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function ensureICanDeleteContact(Seller $I): void
    {
        foreach ($this->createdContacts as $id => $name) {
            $I->needPage(Url::to('@contact'));
            $this->indexPage->gridView->filterBy(
                Input::asTableFilter($I, 'Name'), $name
            );
            $this->indexPage->gridView->selectRowById($id);
            $I->pressButton('Delete');
            $I->acceptPopup();
            $I->waitForPageUpdate();
            $I->closeNotification('Contact was deleted');
        }
    }

    /**
     * @return array
     */
    protected function testContactData(): array
    {
        $basicData = [
            'inputs' => [
                'first_name'    => null,
                'last_name'     => 'Manager',
                'email'         => 'hipanel_test_manager@hiqdev.com',
                'abuse_email'   => 'hipanel_test_manager+abuse@hiqdev.com',
                'organization'  => 'HiQDev',
                'street1'       => 'Test address',
                'city'          => 'Test',
                'province'      => 'Testing',
                'postal_code'   => 'TEST',
                'voice_phone'   => null,
                'icq'           => '1002893',
                'skype'         => 'hipanel_test_manager',
                'jabber'        => 'hipanel_test_manager@hiqdev.com',
                'telegram'      => 'hipanel_test_manager',
                'whatsapp'      => '123456789012',
                'social_net'    => 'https://facebook.com/hipanel_test_manager',
            ],
            'selects' => [
                'country'       => 'Algeria',
                'client'        => 'hipanel_test_manager',
            ],
            'phoneCountryCode'  => null,
        ];

        $varData = [
            [
                'voice_phone'       => '(965) 449-99-99',
                'phoneCountryCode'  => 'ru',
            ],
            [
                'voice_phone'       => '093 000-1122',
                'phoneCountryCode'  => 'ua',
            ],
            [
                'voice_phone'       => '+3 8 093 000-1122',
                'phoneCountryCode'  => 'ua',
            ],
        ];

        $data = [];

        foreach ($varData as $varItem) {
            $tmp = $basicData;
            $tmp['inputs']['first_name'] = 'Test' . uniqid();
            $tmp['inputs']['voice_phone'] = $varItem['voice_phone'];
            $tmp['phoneCountryCode'] = $varItem['phoneCountryCode'];

            $data[] = $tmp;
        }

        return $data;
    }
}
