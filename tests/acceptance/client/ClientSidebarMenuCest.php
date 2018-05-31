<?php

namespace hipanel\modules\client\tests\acceptance\client;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Client;

class ClientSidebarMenuCest
{
    public function ensureMenuIsOk(Client $I)
    {
        (new SidebarMenu($I))->ensureDoesNotContain('Clients');
    }
}
