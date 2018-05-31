<?php

namespace hipanel\modules\client\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;
use yii\helpers\Url;

class ClientSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I)
    {
        $I->login();
        $menu = new SidebarMenu($I);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureDoesNotContain('Clients');
    }
}
