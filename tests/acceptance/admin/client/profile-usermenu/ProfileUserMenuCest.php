<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ProfileUserMenuCest
{
    public function ensureThatProfileUserMenuWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $menu = [
            'You can change your avatar at Gravatar.com',
            'Change password',
            'Enable two factor authorization',
            'Pincode settings',
            'IP address restrictions',
            'Notification settings',
            'Domain settings',
            'Finance settings',
            'Ticket settings',
        ];
        foreach ($menu as $item) {
            $I->see($item, '//div[@class="profile-usermenu"]/ul/li');
        }
    }
}
