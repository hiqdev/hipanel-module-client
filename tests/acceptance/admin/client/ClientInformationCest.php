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

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;
use Yii;

class ClientInformationCest
{
    /**
     * @dataProvider provideClientInfo
     */
    public function ensureThatClientInformationBlockWorks(Admin $I, Example $clientInfo): void
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));

        $key = 'data-resizable-column-id';
        foreach ($clientInfo as $tr) {
            if (isset($tr['visible']) && $tr['visible'] === false) {
                continue;
            }
            $I->seeElement(['css' => 'table tbody tr th'], [$key => $tr['column_id']]);
            $I->see($tr['text'], "//table/tbody/tr/th[@$key='{$tr['column_id']}']");
            if ($tr['td']) {
                $I->see($tr['td'], "//table/tbody/tr/th[@$key='{$tr['column_id']}']/../td");
            }
        }
        $I->click('1 contact');
        $I->seeCurrentUrlEquals(Url::to(Url::toSearch('contact', ['client_id' => $I->id])));
    }

    protected function provideClientInfo()
    {
        return [
            [
                ['column_id' => 'seller_id',   'text' => 'Reseller',    'td' => 'hipanel_test_reseller'],
                ['column_id' => 'name',        'text' => 'Name',        'td' => 'Test Admin'],
                ['column_id' => 'language',    'text' => 'Language',    'td' => 'English'],
                ['column_id' => 'type',        'text' => 'Type',        'td' => 'Admin'],
                ['column_id' => 'state',       'text' => 'Status',      'td' => 'Ok'],
                ['column_id' => 'create_time', 'text' => 'Registered',  'td' => null],
                ['column_id' => 'update_time', 'text' => 'Last update', 'td' => null],
                ['column_id' => 'tickets',     'text' => 'Tickets',     'td' => null],
                ['column_id' => 'servers',     'text' => 'Servers',     'td' => null],
                ['column_id' => 'domains',     'text' => 'Domains',     'td' => null, 'visible' => Yii::getAlias('@domain', false)],
                ['column_id' => 'contacts',    'text' => 'Contacts',    'td' => '1 contact'],
                ['column_id' => 'hosting',     'text' => 'Hosting',     'td' => null],
            ]
        ];
    }
}
