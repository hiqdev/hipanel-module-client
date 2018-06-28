<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
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
            [$key => 'name_with_verification',  'text' => 'Name',         'td' => 'Admin HiPanel'],
            [$key => 'organization',            'text' => 'Organization', 'td' => 'HiQDev'],
            [$key => 'email_with_verification', 'text' => 'Email',        'td' => 'hipanel_test_admin@hiqdev.com'],
            [$key => 'abuse_email',             'text' => 'Abuse email',  'td' => 'hipanel_test_admin+abuse@hiqdev.com'],
            [$key => 'messengers',              'text' => 'Messengers',   'td' => "Skype: hipanel_test_admin\n" .
                                                                                  "ICQ: 888777\n" .
                                                                                  "Jabber: hipanel_test_admin@hiqdev.com\n" .
                                                                                  "Telegram: hipanel_test_admin\n" .
                                                                                  'WhatsApp: 380932003040', ],
            [$key => 'social_net',              'text' => 'Social',       'td' => 'https://facebook.com/hipanel_test_admin'],
            [$key => 'voice_phone',             'text' => 'Phone',        'td' => '380932003040'],
            [$key => 'fax_phone',               'text' => 'Fax',          'td' => '380445203040'],
            [$key => 'street',                  'text' => 'Street',       'td' => '42 Foo str.'],
            [$key => 'city',                    'text' => 'City',         'td' => 'Bar'],
            [$key => 'province',                'text' => 'Province',     'td' => 'Kyiv'],
            [$key => 'postal_code',             'text' => 'Postal code',  'td' => '01001'],
            [$key => 'country_name',            'text' => 'Country',      'td' => 'Ukraine'],
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
