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
        $this->ensureICanSeeAdvancedSearchBox();
        $this->ensureICanSeeLegendBox();
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Input('Login'),
            new Input('Note'),
            new Input('Name'),
            new Input('Email'),
            new Input('Reseller'),
            new Select2('Reseller'),
            new Input('Types'),
            new Input('States'),
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
