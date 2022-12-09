<?php 

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ClientViewCest
{
    public function ensureViewModeWorks(Seller $I): void
    {
        $I->login();
        $I->needPage(Url::to('@client/index'));
        $filters = $this->getDataForViewPage();
        $this->ensureViewFilterWorks($I, $filters);
    }

    private function ensureViewFilterWorks(Seller $I, array $options): void
    {
        $indexPage = new IndexPage($I);

        foreach ($options as $key => $element) {
            $indexPage->containsColumns($element, $key);
        }
    }

    private function getDataForViewPage(): array
    {
        return [
            'Common'     => [
                'Login',
                'Client',
                'Reseller',
                'Type',
                'Status',
                'Balance',
                'Credit',
            ],
            'Servers'    => [
                'Login',
                'Client',
                'Reseller',
                'Type',
                'Registered / Last Update',
                'Status',
                'Accounts',
                'Balances',
            ],
            'Documents'  => [
                'Login',
                'Reseller',
                'Requisites',
                'Language',
            ],
            'Referral'   => [
                'Login',
                'Reseller',
                'Referer',
                'Referrals',
                'Earning',
                'Referral tariff',
                'Status',
                'Balance',
            ],
        ];
    }
}
