<?php 

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use Codeception\Example;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ClientViewCest
{
    /**
     * @dataProvider provideDataView
     */
    public function ensureViewModeWorks(Seller $I, Example $example)
    {
        $I->login();
        $I->needPage(Url::to('@client/index'));
        $this->ensureViewFilterWorks($I, $example);
    }

    private function ensureViewFilterWorks(Seller $I, Example $viewExample): void
    {
        $indexPage = new IndexPage($I);

        foreach ($viewExample as $key => $element) {
            $indexPage->containsColumns($element, $key);
        }
    }

    private function provideDataView(): array
    {
        return [
            'view' => [
                'Common'     => [
                    'Login',
                    'Client',
                    'Description',
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
            ],
        ];
    }
}
