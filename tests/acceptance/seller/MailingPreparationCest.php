<?php

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Page\Widget\Input\Textarea;
use hipanel\tests\_support\Step\Acceptance\Seller;

class MailingPreparationCest
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
        $I->needPage(Url::to('/mailing/prepare'));
        $I->see('Mailing preparation', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
    }

    private function ensureICanSeeAdvancedSearchBox(Seller $I)
    {
        $this->index->containsFilters([
            Select2::asAdvancedSearch($I, 'Sellers'),
            Select2::asAdvancedSearch($I, 'Client type'),
            Select2::asAdvancedSearch($I, 'Mailing Type'),
            Textarea::asAdvancedSearch($I, 'Clients'),
            Select2::asAdvancedSearch($I, 'Languages'),
            Select2::asAdvancedSearch($I, 'Servers'),
            Input::asAdvancedSearch($I, 'Server (partial match)'),
            Select2::asAdvancedSearch($I, 'State'),
            Select2::asAdvancedSearch($I, 'Type'),
            Input::asAdvancedSearch($I, 'Switch'),
            Input::asAdvancedSearch($I, 'Rack'),
            Input::asAdvancedSearch($I, 'PDU'),
        ]);
    }
}
