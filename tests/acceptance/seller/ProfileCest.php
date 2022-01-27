<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\tests\_support\Step\Acceptance\Seller;
use yii\helpers\Url;

class ProfileCest
{
    public function ensureThatProfilePageWorks(Seller $I)
    {
        $I->login();
        $I->amOnPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->see('Client detailed information');
        $I->see('reseller', '.profile-user-role');
    }
}
