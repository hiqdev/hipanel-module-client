<?php

namespace hipanel\modules\client\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ContactsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Admin $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to('@contact'));
        $I->see('Contact', 'h1');
        $I->seeLink('Create', Url::to('create'));
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Admin $I)
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I, 'Name'),
            Input::asAdvancedSearch($I, 'Email'),
            Select2::asAdvancedSearch($I,'Client'),
            Select2::asAdvancedSearch($I,'Reseller'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Delete',
        ]);
        $this->index->containsColumns([
            'Name',
            'Email',
            'Client',
            'Reseller',
        ], 'Common');
        $this->index->containsColumns([
            'Name',
            'Requisites',
        ], 'Requisites');
    }
}
