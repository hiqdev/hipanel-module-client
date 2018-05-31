<?php

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\tests\_support\Page\SidebarMenu;
use hipanel\tests\_support\Step\Acceptance\Seller;
use yii\helpers\Url;

class ClientSidebarMenuCest
{
    public function ensureMenuIsOk(Seller $I)
    {
        $I->login();
        $menu = new SidebarMenu($I);

        $I->amOnPage(Url::to(['/']));
        $menu->ensureContains('Clients', [
            'Clients' => '/client/client/index',
            'Contacts' => '/client/contact/index',
            'Documents' => '/document/document/index',
            'Mailing preparation' => '/mailing/prepare/index',
        ]);
    }
}
