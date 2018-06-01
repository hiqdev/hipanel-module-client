<?php

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ClientSidebarMenuCest
{
    public function ensureMenuIsOk(Seller $I)
    {
        (new SidebarMenu($I))->ensureContains('Clients', [
            'Clients' => '@client/index',
            'Contacts' => '@contact/index',
            'Documents' => '@document/index',
            'Mailing preparation' => '/mailing/prepare/index',
        ]);
    }
}
