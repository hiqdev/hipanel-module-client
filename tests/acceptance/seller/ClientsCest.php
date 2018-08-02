<?php

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ClientsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Seller $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Seller $I)
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
            'Balance',
            'Credit',
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
        $this->index->containsColumns([
            'Login',
            'Reseller',
            'Requisites',
            'Language',
        ], 'Documents');
    }
}
