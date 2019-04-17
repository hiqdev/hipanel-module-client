<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ContactInformationCest
{
    public function ensureThatContactInformationBlockWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->seeLink('Details', Url::to(['@contact/view',  'id' => $I->id]));
        $I->seeLink('Change', Url::to(['@contact/update',  'id' => $I->id]));
        $key = 'data-resizable-column-id';
        $tbody = [
            [$key => 'name_with_verification',  'text' => 'Name',         'td' => 'Test Admin'],
            [$key => 'organization',            'text' => 'Organization', 'td' => 'HiQDev'],
            [$key => 'email_with_verification', 'text' => 'Email',        'td' => 'hipanel_test_admin@hiqdev.com'],
            [$key => 'abuse_email',             'text' => 'Abuse email',  'td' => 'hipanel_test_admin+abuse@hiqdev.com'],
            [$key => 'messengers',              'text' => 'Messengers',   'td' => "Skype: hipanel_test_admin\n" .
                                                                                  "ICQ: {$I->id}\n" .
                                                                                  "Jabber: hipanel_test_admin@hiqdev.com\n" .
                                                                                  "Telegram: hipanel_test_admin\n" .
                                                                                  'WhatsApp: 123456789012', ],
            [$key => 'social_net',              'text' => 'Social',       'td' => 'https://facebook.com/hipanel_test_admin'],
            [$key => 'voice_phone',             'text' => 'Phone',        'td' => '123456789012'],
            [$key => 'fax_phone',               'text' => 'Fax',          'td' => '987654321098'],
            [$key => 'street',                  'text' => 'Address',      'td' => '42 Test str.'],
            [$key => 'city',                    'text' => 'City',         'td' => 'Test'],
            [$key => 'province',                'text' => 'Province',     'td' => 'Testing'],
            [$key => 'postal_code',             'text' => 'Postal code',  'td' => 'TEST'],
            [$key => 'country_name',            'text' => 'Country',      'td' => 'Trinidad And Tobago'],
        ];
        foreach ($tbody as $tr) {
            $I->seeElement(['css' => 'table tbody tr th'], [$key => $tr[$key]]);
            $I->see($tr['text'], "//table/tbody/tr/th[@$key='{$tr[$key]}']");
            if ($tr['td'] !== '') {
                $I->see($tr['td'], "//table/tbody/tr/th[@$key='{$tr[$key]}']/../td");
            }
        }
    }
}
