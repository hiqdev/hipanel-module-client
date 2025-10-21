<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */
namespace hipanel\modules\client\tests\acceptance\manager;

use Codeception\Example;
use hipanel\modules\client\tests\acceptance\CommonContactActions;
use hipanel\tests\_support\Step\Acceptance\Manager;

class ContactsCest extends CommonContactActions
{
    /**
     * @dataProvider testContactData
     *
     * @param Manager $I
     * @param Example $data
     * @throws \Exception
     */
    public function ensureICanCreateContact(Manager $I, Example $data): void
    {
        parent::create($I, $data);
    }

    /**
     * @param Manager $I
     * @throws \Exception
     */
    public function ensureICantCreateIncorrectContact(Manager $I): void
    {
        parent::createIncorrect($I);
    }

    /**
     * @param Manager $I
     * @throws \Codeception\Exception\ModuleException
     */
    public function ensureICanDeleteContact(Manager $I): void
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
                'voice_phone'   => null,
                'icq'           => '1002893',
                'skype'         => 'hipanel_test_manager',
                'jabber'        => 'hipanel_test_manager@hiqdev.com',
                'telegram'      => 'hipanel_test_manager',
                'whatsapp'      => '123456789012',
                'social_net'    => 'https://facebook.com/hipanel_test_manager',
            ],
            'selects' => [
                'client'        => 'hipanel_test_manager',
                'currency'      => 'usd',
            ],
            'textarea' => [
              'bank_account'    => 'UATEST0123456IBAN',
            ],
            'phoneCountryCode'  => null,
        ];

        $varData = [
            [
                'voice_phone'       => '+7 (965) 449-99-99',
                'phoneCountryCode'  => 'ru',
                'postal_code'   => '123445',
                'country'       => 'Russian Federation',
            ],
            [
                'voice_phone'       => '+38 093 000-1122',
                'phoneCountryCode'  => 'ua',
                'postal_code'   => '12344',
                'country'       => 'Ukraine',
            ],
            [
                'voice_phone'       => '+3 8 093 000-1122',
                'phoneCountryCode'  => 'ua',
                'postal_code'   => '12345',
                'country'       => 'Ukraine',
            ],
        ];

        $data = [];

        foreach ($varData as $varItem) {
            $tmp = $basicData;
            $tmp['inputs']['first_name'] = 'Test' . uniqid();
            $tmp['inputs']['voice_phone'] = $varItem['voice_phone'];
            $tmp['inputs']['postal_code'] = $varItem['postal_code'];
            $tmp['selects']['country'] = $varItem['country'];
            $tmp['phoneCountryCode'] = $varItem['phoneCountryCode'];

            $data[] = $tmp;
        }

        return $data;
    }
}
