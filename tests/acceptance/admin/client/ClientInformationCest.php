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
            [$key => 'update_time', 'text' => 'Last update', 'td' => null],
            [$key => 'tickets',     'text' => 'Tickets',     'td' => null],
            [$key => 'servers',     'text' => 'Servers',     'td' => null],
            [$key => 'domains',     'text' => 'Domains',     'td' => null],
            [$key => 'contacts',    'text' => 'Contacts',    'td' => '1 contact'],
            [$key => 'hosting',     'text' => 'Hosting',     'td' => null],
        ];
        foreach ($tbody as $tr) {
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
