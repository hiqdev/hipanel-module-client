<?php

namespace hipanel\modules\client\tests\acceptance\seller;

use hipanel\helpers\Url;
use Codeception\Example;
use hipanel\modules\client\tests\_support\Page\document\Create;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Seller;

class DocumentsFieldsCest
{
    /**
     * @var Create
     */
    private $create;

    public function _before(Seller $I)
    {
        $this->create = new Create($I);
    }

    public function ensureICantCreateDocumentWithoutData(Seller $I)
    {
        $I->login();
        $I->needPage(Url::to('@document/create'));
        $I->click('Save');;
        $this->create->containsBlankFieldsError(['Title', 'Sender', 'Receiver', 'Type']);
    }

    /**
     * @dataProvider provideDocumentData
     */
    public function ensureICanFillMainDocumentsFields(Seller $I, Example $example)
    {
        $I->needPage(Url::to('@document/create'));
        $exampeArray = iterator_to_array($example->getIterator());
        $this->create->fillMainDocumentFields($exampeArray['document']);
        $I->wait(3);
        $I->click('Save');

        $this->create->dontContainsBlankFieldsError(['Sender']);
    }
    
    private function provideDocumentData()
    {
        $account = 'Test Reseller';
        return  [
            'documents' => [
                'document' => [
                    'client'   => 'hipanel_test_reseller',
                    'title'    => 'Docoument #' . uniqid(),
                    'sender'   => $account,
                    'receiver' => $account,
                    'type'     => 'Invoice',
                    'class'    => 'Client',
                    'objectId' => 'hipanel_test_reseller',
                ],
            ],
        ];
    }
}
