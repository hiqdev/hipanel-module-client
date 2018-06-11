<?php

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class UsdAccountCest
{
    public function ensureThatUsdAccountBlockWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $key = 'data-resizable-column-id';
        $tbody = [
            [$key => 'contact',   'text' => 'Contact',         'td' => 'Admin HiPanel'],
            [$key => 'requisite', 'text' => 'Payment details', 'td' => 'Test Reseller'],
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
