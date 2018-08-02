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
        $this->ensureICanSeeAdvancedSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox()
    {
        $this->index->containsFilters([
            new Input('Sellers'),
            new Input('Client type'),
            new Select2('Mailing Type'),
            new Textarea('Client logins list (comma-, or space-separated)'),
            new Input('Languages'),
            new Input('Servers'),
            new Input('Server (partial match)'),
            new Input('State'),
            new Input('Type'),
            new Input('Switch'),
            new Input('Rack'),
            new Input('PDU'),
            new Input('Domain'),
            new Input('Domain zones'),
        ]);
    }
}
