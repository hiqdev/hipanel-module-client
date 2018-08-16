<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;
use Yii;

class ClientViewSkeletonCest
{
    public function ensureThatClientSkeletonPageVisible(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->see('Client detailed information #' . $I->id);
        $I->see('admin', '.profile-user-role');
        $I->see('Client information');
        $I->see('Contact information');
        $I->see('USD account');
        $menu = [
            ['text' => 'You can change your avatar at Gravatar.com'],
            ['text' => 'Change password'],
            ['text' => 'Enable two factor authorization'],
            ['text' => 'Pincode settings'],
            ['text' => 'IP address restrictions'],
            ['text' => 'Notification settings'],
            ['text' => 'Domain settings', 'visible' => Yii::getAlias('@domain', false)],
            ['text' => 'Financial settings'],
            ['text' => 'Ticket settings'],
        ];
        foreach ($menu as $item) {
            if (array_key_exists('visible', $item) && !$item['visible']) {
                continue;
            }
            $I->see($item['text'], '.profile-usermenu');
        }
    }
}
