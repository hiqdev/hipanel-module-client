<?php

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

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
            [$key => 'organization',            'text' => 'Organization', 'td' => ''],
            [$key => 'email_with_verification', 'text' => 'Email',        'td' => 'hipanel_test_admin@hiqdev.com'],
            [$key => 'abuse_email',             'text' => 'Abuse email',  'td' => ''],
            [$key => 'messengers',              'text' => 'Messengers',   'td' => ''],
            [$key => 'social_net',              'text' => 'Social',       'td' => ''],
            [$key => 'voice_phone',             'text' => 'Phone',        'td' => ''],
            [$key => 'fax_phone',               'text' => 'Fax',          'td' => ''],
            [$key => 'street',                  'text' => 'Street',       'td' => ''],
            [$key => 'city',                    'text' => 'City',         'td' => ''],
            [$key => 'province',                'text' => 'Province',     'td' => ''],
            [$key => 'postal_code',             'text' => 'Postal code',  'td' => ''],
            [$key => 'country_name',            'text' => 'Country',      'td' => ''],
        ];
        foreach ($tbody as $tr ) {
            $I->seeElement(['css' => 'table tbody tr th'], [$key => $tr[$key]]);
            $I->see($tr['text'], "//table/tbody/tr/th[@$key='{$tr[$key]}']");
            if ($tr['td'] !== '') {
                $I->see($tr['td'], "//table/tbody/tr/th[@$key='{$tr[$key]}']/../td");
            }
        }
    }
}
