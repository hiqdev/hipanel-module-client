<?php
declare(strict_types=1);
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ClientsCest
{
    public function ensureIndexPageWorks(Seller $I): void
    {
        $index = new IndexPage($I);

        $I->login();
        $I->needPage(Url::to('@client'));
        $I->see('Clients', 'h1');
        $this->ensureICanSeeMainButtons($I);
        $this->ensureICanSeeAdvancedSearchBox($index, $I);
        $this->ensureICanSeeLegendBox($index);
        $this->ensureICanSeeBulkSearchBox($index);
    }

    private function ensureICanSeeMainButtons(Seller $I): void
    {
        $I->seeLink('Create client', Url::to('@client/create'));
        $I->seeLink('Delete by logins');
    }

    private function ensureICanSeeAdvancedSearchBox(IndexPage $index, Seller $I): void
    {
        $index->containsFilters([
            Input::asAdvancedSearch($I, 'Login or Email'),
            Input::asAdvancedSearch($I, 'Note'),
            Input::asAdvancedSearch($I, 'Name'),
            Input::asAdvancedSearch($I, 'Email'),
            Input::asAdvancedSearch($I, 'Reseller'),
            Select2::asAdvancedSearch($I,'Reseller'),
            Select2::asAdvancedSearch($I, 'Types'),
            Select2::asAdvancedSearch($I, 'States'),
        ]);
    }

    private function ensureICanSeeLegendBox(IndexPage $index): void
    {
        $index->containsLegend([
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

    private function ensureICanSeeBulkSearchBox(IndexPage $index): void
    {
        $index->containsBulkButtons([
            'Basic actions',
        ]);
        $index->containsColumns([
            'Login',
            'Client',
            'Reseller',
            'Type',
            'Status',
            'Balance',
            'Credit',
        ], 'Common');
        $index->containsColumns([
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
        $index->containsColumns([
            'Login',
            'Reseller',
            'Requisites',
            'Language',
        ], 'Documents');
    }
}
