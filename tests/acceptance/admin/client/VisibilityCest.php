<?php

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class VisibilityCest
{
    public function ensureThatClientPageVisible(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->see('Client detailed information #' . $I->id);
        $I->see('admin', '.profile-user-role');
        $I->see('Client information');
        $I->see('Contact information');
        $I->see('USD account');
        $menu = [
            'You can change your avatar at Gravatar.com',
            'Change password',
            'Enable two factor authorization',
            'Pincode settings',
            'IP address restrictions',
            'Notification settings',
            'Domain settings',
            'Ticket settings',
        ];
        foreach ($menu as $item) {
            $I->see($item, '.profile-usermenu');
        }
    }
}

