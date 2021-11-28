<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager;

use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Manager;
use hipanel\tests\_support\Page\Widget\Input\Input;

class VerifyUserCest
{
    public function ensureICanVerifyUser(Manager $I): void
    {
        $user = 'hipanel_test_user';

        $I->login();
        $I->needPage(Url::to('@client'));

        Input::asAdvancedSearch($I, 'Login or Email')->setValue($user);

        $I->waitForPageUpdate();

        $index->sortBy('Login');
        $I->waitForPageUpdate();

        $I->clickLink($user);

        $this->verifyUser();
    }

    private function verifyUser(Manager $I): void
    {
        $I->seeInCurrentUrl('client/client/view?id=');

        $I->click("//span[contains(@class, 'bootstrap-switch-label')]");
        $I->closeNotification('Client verification status has been changed');
    }

}
