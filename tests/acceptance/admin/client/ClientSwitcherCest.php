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
