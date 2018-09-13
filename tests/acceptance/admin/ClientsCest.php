<?php

namespace hipanel\modules\client\tests\acceptance\admin;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;

class ClientsCest
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
        $I->needPage(Url::to('@client'));
        $I->see('Clients', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Admin $I)
    {
        $this->index->containsFilters([
            Input::asAdvancedSearch($I,'Login'),
            Input::asAdvancedSearch($I, 'Note'),
            Input::asAdvancedSearch($I, 'Name'),
            Input::asAdvancedSearch($I, 'Email'),
            Input::asAdvancedSearch($I, 'Reseller'),
            Select2::asAdvancedSearch($I,'Reseller'),
            Select2::asAdvancedSearch($I, 'Types'),
            Select2::asAdvancedSearch($I, 'States'),
        ]);
    }

    private function ensureICanSeeLegendBox()
    {
        $this->index->containsLegend([
            'Partner',
            'Copy',
            'Client',
            'Employee',
            'Reseller',
            'Administrator',
            'Manager',
            'Owner',
            'Support',
        ]);
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            'Basic actions',
        ]);
        $this->index->containsColumns([
            'Login',
            'Client',
            'Reseller',
            'Type',
            'Status',
        ], 'Common');
        $this->index->containsColumns([
            'Login',
            'Client',
            'Reseller',
            'Type',
            'Registered / Last Update',
            'Status',
            'Servers',
            'Accounts',
            'Balances',
        ], 'Servers');
    }
}
