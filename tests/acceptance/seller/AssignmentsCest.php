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
        $I->login();
        $I->needPage(Url::to('@client/assignments/index'));
        $I->see('Assignments', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox($I);
    }

    private function ensureICanSeeAdvancedSearchBox(Manager $I): void
    {
        $index = new IndexPage($I);

        $index->containsFilters([
            Input::asAdvancedSearch($I, 'Login'),
            Select2::asAdvancedSearch($I, 'Client'),
            Select2::asAdvancedSearch($I, 'Reseller'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox(Manager $I): void
    {
        $index = new IndexPage($I);

        $index->containsBulkButtons([
            'Set assignments',
        ]);
        $index->containsColumns([
            'Login',
            'Reseller',
            'Type',
            'Assignments',
        ]);
    }
}
