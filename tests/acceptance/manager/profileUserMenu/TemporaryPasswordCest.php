<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager\profile\usermenu;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Manager;
use hipanel\tests\_support\Page\Widget\Input\Input;

class TemporaryPasswordCest
{
    public function _before(Manager $I): void
    {
        $I->login();
        $I->needPage(Url::to('@client/index'));
    }

    public function ensureTemporaryPasswordWorksCorrectly(Manager $I): void
    {
        $I->markTestSkipped('Moved to Playwright');
        $index = new IndexPage($I);
        $user = 'hipanel_test_user';

        $I->see('Clients', 'h1');
        Input::asAdvancedSearch($I, 'Login or Email')->setValue($user);

        $I->waitForPageUpdate();

        $index->sortBy('Login');
        $I->waitForPageUpdate();

        $I->click($user);
        $I->waitForPageUpdate();
        $I->see($user, 'h1');

        $this->ensureTemporaryPasswordPopupWorksCorrectly($I);
    }

    private function ensureTemporaryPasswordPopupWorksCorrectly(Manager $I): void
    {
        $I->clickLink('Temporary password');
        $I->waitForPageUpdate();

        $I->pressButton('Confirm');
        $I->waitForPageUpdate();

        $I->closeNotification('Temporary password was sent on your email');
    }
}
