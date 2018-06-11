<?php

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class ProfileUserMenuCest
{
    public function ensureThatProfileUserMenuWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $menu = [
            ['text' => 'You can change your avatar at Gravatar.com', 'selector' => '//a[@href="http://gravatar.com"]'],
            ['text' => 'Change password',                            'selector' => '//a[@data-target="#w0"]'],
            ['text' => 'Enable two factor authorization',            'selector' => '//a[@*]'],
            ['text' => 'Pincode settings',                           'selector' => '//a[@data-target="#w2"]'],
            ['text' => 'IP address restrictions',                    'selector' => '//a[@data-target="#w3"]'],
            ['text' => 'Notification settings',                      'selector' => '//a[@data-target="#w4"]'],
            ['text' => 'Domain settings',                            'selector' => '//a[@data-target="#w5"]'],
            ['text' => 'Ticket settings',                            'selector' => '//a[@data-target="#w6"]'],
        ];
        foreach ($menu as $item) {
            $I->see($item['text'], $item['selector']);
        }
    }
}
