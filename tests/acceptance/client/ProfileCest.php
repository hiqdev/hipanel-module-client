<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\client;

use hipanel\tests\_support\Step\Acceptance\Client;
use yii\helpers\Url;

class ProfileCest
{
    public function ensureThatProfilePageWorks(Client $I)
    {
        $I->login();
        $I->amOnPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->see('Client detailed information');
        $I->see('client', '.profile-user-role');
    }
}
