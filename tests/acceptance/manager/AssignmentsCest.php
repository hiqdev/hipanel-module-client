<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Manager;

class AssignmentsCest
{
    public function ensureIndexPageWorks(Manager $I): void
    {
        $index = new IndexPage($I);

        $I->login();
        $I->needPage(Url::to('@client/assignments/index'));
        $I->see('Assignments', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I, $index);
        $this->ensureICanSeeBulkSearchBox($I, $index);
        $this->ensureICanAssignUser($I, $index);
    }

    private function ensureICanSeeAdvancedSearchBox(Manager $I, IndexPage $index): void
    {
        $index->containsFilters([
            Input::asAdvancedSearch($I, 'Login'),
            Select2::asAdvancedSearch($I, 'Client'),
            Select2::asAdvancedSearch($I, 'Reseller'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox(Manager $I, IndexPage $index): void
    {
        $index->containsBulkButtons([
            'Set assignments',
        ]);
        $index->containsColumns([
            'Login',
            'Reseller',
            'Type',
            'Assignments',
        ],);
    }

    private function ensureICanAssignUser(Manager $I, IndexPage $index): void
    {
        $I->needPage(Url::to('@client/assignments/index'));
        $login = $I->grabTextFrom('//tbody//tr[1]//td[2]');

        $row = $index->getRowNumberInColumnByValue('Login', $login);

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
