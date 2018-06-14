<?php

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class ClientInformationCest
{
    public function ensureThatClientInformationBlockWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $key = 'data-resizable-column-id';
        $tbody = [
            [$key => 'seller_id',   'text' => 'Reseller',    'td' => 'hipanel_test_reseller@hiqdev.com'],
            [$key => 'name',        'text' => 'Name',        'td' => 'Admin HiPanel'],
            [$key => 'language',    'text' => 'Language',    'td' => 'English'],
            [$key => 'type',        'text' => 'Type',        'td' => 'Admin'],
            [$key => 'state',       'text' => 'Status',      'td' => 'Ok'],
            [$key => 'create_time', 'text' => 'Registered',  'td' => 'Feb 27, 2017, 4:56:32 PM'],
            [$key => 'update_time', 'text' => 'Last update', 'td' => 'Jun 13, 2018, 6:38:41 AM'],
            [$key => 'tickets',     'text' => 'Tickets',     'td' => ''],
            [$key => 'servers',     'text' => 'Servers',     'td' => ''],
            [$key => 'domains',     'text' => 'Domains',     'td' => ''],
            [$key => 'contacts',    'text' => 'Contacts',    'td' => '1 contact'],
            [$key => 'hosting',     'text' => 'Hosting',     'td' => ''],
        ];
        foreach ($tbody as $tr ) {
            $I->seeElement(['css' => 'table tbody tr th'], [$key => $tr[$key]]);
            $I->see($tr['text'], "//table/tbody/tr/th[@$key='{$tr[$key]}']");
            if ($tr['td'] !== '') {
                $I->see($tr['td'], "//table/tbody/tr/th[@$key='{$tr[$key]}']/../td");
            }
        }
        $I->click('1 contact');
        $I->seeCurrentUrlEquals(Url::to(Url::toSearch('contact', ['client_id' => $I->id])));
    }
}
