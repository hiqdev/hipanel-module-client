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
    public function ensureExportIsAvailable(Seller $I, Example $example): void
    {
        $I->login();
        $I->needPage(Url::to('@client/index'));
        $exampleArray = iterator_to_array($example->getIterator());
        $this->ensureICanSeeExportOption($I, $exampleArray);
    }

    private function ensureICanSeeExportOption(Seller $I, array $exportOption): void
    {
        $indexPage = new IndexPage($I);

        $indexPage->openAndSeeBulkOptionByName('Export', $exportOption);
    }

    private function provideDataView(): array
    {
        return [
            'export' => [
                'CSV',
                'TSV',
                'Excel XLSX',
            ],
        ];
    }
}
