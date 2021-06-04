<?php 

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use Codeception\Example;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Seller;

class ClientExportCest
{
    /**
     * @dataProvider provideDataView
     */
    public function ensureExportIsAvailable(Seller $I, Example $example)
    {
        $I->login();
        $I->needPage(Url::to('@client/index'));
        $this->ensureICanSeeExportOption($I, $example);
    }

    private function ensureICanSeeExportOption(Seller $I, Example $exportExample): void
    {
        $indexPage = new IndexPage($I);

        $test = iterator_to_array($exportExample->getIterator());
        $indexPage->openAndSeeBulkOptionByName($test);
    }

    private function provideDataView(): array
    {
        return [
            'export' => [
                'Export' => [
                    'CSV',
                    'TSV',
                    'Excel XLSX',
                ],
            ],
        ];
    }
}
