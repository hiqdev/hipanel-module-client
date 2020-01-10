<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */
namespace hipanel\modules\client\tests\acceptance\admin\contacts;

use Codeception\Example;
use hipanel\modules\client\tests\acceptance\CommonContactActions;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ContactsCest extends CommonContactActions
{
    /**
     * @dataProvider testContactData
     *
     * @param Seller $I
     * @param Example $data
     * @throws \Exception
     */
    public function ensureICanCreateContact(Seller $I, Example $data): void
    {
        parent::create($I, $data);
    }

    /**
     * @param Seller $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function ensureICanUpdateContact(Seller $I): void
    {
        parent::update($I);
    }

    /**
     * @param Seller $I
     * @throws \Exception
     */
    public function ensureICantCreateIncorrectContact(Seller $I): void
    {
        parent::createIncorrect($I);
    }

    /**
     * @param Seller $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function ensureICanDeleteContact(Seller $I): void
    {
        parent::delete($I);
    }

    /**
     * @inheritDoc
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
