<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */
namespace hipanel\modules\client\tests\acceptance\admin\contacts;

use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;
use yii\helpers\Url;

class IndexPageCest
{
    /** @var IndexPage */
    private $indexPage;

    public function ensureIndexPageWorks(Admin $I): void
    {
        $this->indexPage = new IndexPage($I);
        $I->needPage(Url::to('@contact'));
        $I->see('Contact', 'h1');
        $I->seeLink('Create', Url::to('create'));
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox($I);
    }

    private function ensureICanSeeAdvancedSearchBox(Admin $I): void
    {
        $this->indexPage->containsFilters([
            Input::asAdvancedSearch($I, 'Name'),
            Input::asAdvancedSearch($I, 'Email'),
            Select2::asAdvancedSearch($I, 'Client'),
            Select2::asAdvancedSearch($I, 'Reseller'),
        ]);
    }

    private function ensureICanSeeBulkSearchBox(Admin $I): void
    {
        $this->indexPage->containsBulkButtons([
            'Delete',
        ]);
        $this->indexPage->containsColumns([
            'Name',
            'Email',
            'Client',
            'Reseller',
        ], 'Common');
        $this->indexPage->containsColumns([
            'Name',
            'Requisites',
        ], 'Requisites');
    }
}
