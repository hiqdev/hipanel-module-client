<?php

namespace hipanel\modules\client\tests\acceptance\admin;

use hipanel\tests\_support\Step\Acceptance\Admin;
use yii\helpers\Url;

class ProfileCest
{
    public function ensureThatProfilePageWorks(Admin $I)
    {
        $I->login();
        $I->amOnPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->see('Client detailed information');
        $I->see('admin', '.profile-user-role');

    }
}
