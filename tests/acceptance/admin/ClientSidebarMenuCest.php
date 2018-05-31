<?php

namespace hipanel\modules\client\tests\acceptance\admin;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Admin;
use yii\helpers\Url;

class ClientSidebarMenuCest
{
    public function ensureMenuIsOk(Admin $I)
    {
        $I->login();
        $menu = new SidebarMenu($I);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureContains('Clients', [
            'Clients' => '/client/client/index',
            'Contacts' => '/client/contact/index',
        ]);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureDoesNotContain('Clients', [
            'Documents',
            'Mailing preparation',
        ]);
    }
}
