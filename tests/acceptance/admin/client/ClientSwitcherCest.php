<?php

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class ClientSwitcherCest
{
    public function ensureThatClientSwitcherWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->click('.client-switcher');
        $I->waitForElement('.select2-search__field');
        $I->fillField('.select2-search__field', 'hipanel');
        $I->waitForElementNotVisible('.loading-results', 120);
        $I->click('.select2-results__option--highlighted');
        $I->seeCurrentUrlEquals(Url::to(['@client/view', 'id' => $I->id]));
    }
}
