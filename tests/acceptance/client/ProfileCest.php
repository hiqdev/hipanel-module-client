<?php

namespace hipanel\modules\client\tests\acceptance\client;

use hipanel\tests\_support\Step\Acceptance\Client;
use yii\helpers\Url;

class ProfileCest
{
    public function ensureThatProfilePageWorks(Client $I)
    {
        $I->login();
        $I->amOnPage(Url::to(['/client/client/view?id=' . $I->id]));
        $I->see('Client detailed information');
        $I->see('client', '.profile-user-role');

    }
}
