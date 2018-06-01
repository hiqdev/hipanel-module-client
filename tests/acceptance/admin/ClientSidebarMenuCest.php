<?php

namespace hipanel\modules\client\tests\acceptance\admin;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ClientSidebarMenuCest
{
    public function ensureMenuIsOk(Admin $I)
    {
        $menu = new SidebarMenu($I);

        $menu->ensureContains('Clients', [
            'Clients' => '@client/index',
            'Contacts' => '@contact/index',
        ]);

        $menu->ensureDoesNotContain('Clients', [
            'Documents',
            'Mailing preparation',
        ]);
    }
}
