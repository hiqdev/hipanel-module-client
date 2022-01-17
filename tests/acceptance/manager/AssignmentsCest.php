<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager;

use Exception;
use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Manager;

class AssignmentsCest
{
    private IndexPage $index;

    public function _before(Manager $I): void
    {
        $I->login();
        $I->needPage(Url::to('@client/assignments/index'));
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Manager $I): void
    {
        $I->see('Assignments', 'h1');
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Login'),
            Select2::asAdvancedSearch($I, 'Client'),
            Select2::asAdvancedSearch($I, 'Reseller'),
        ]);
        $this->index->containsBulkButtons([
            'Set assignments',
        ]);
        $this->index->containsColumns([
            'Login',
            'Reseller',
            'Type',
            'Assignments',
        ]);
    }

    public function ensureAssignUserFormIsWork(Manager $I, $scenario): void
    {
        $login = 'hipanel_test_user';
        Input::asTableFilter($I, 'Login')->setValue($login);
        $I->click('//body');
        $I->waitForPageUpdate();

        try {
            $row = $this->index->getRowNumberInColumnByValue('Login', $login);
        } catch (Exception $exception) {
            $scenario->skip('No test client found whose seller is `hipanel_test_reseller`');
        }

        $I->checkOption("//tbody/tr[$row]/td[1]/input");
        $I->pressButton('Set assignments');
        $I->waitForPageUpdate();
        $I->see('Set assignments', 'h1');
        $I->see($login, 'strong');
        $I->pressButton('Assign');
        $I->waitForPageUpdate();
        $I->closeNotification('Assignments have been successfully applied.');
        $I->seeInCurrentUrl('/assignments/index');
    }
}
