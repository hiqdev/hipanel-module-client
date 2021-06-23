<?php
namespace hipanel\modules\client\tests\_support\Page\document;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Page\Widget\Input\Dropdown;
use hipanel\tests\_support\Page\Widget\Input\Input;

class Create extends Authenticated
{
    public function fillMainDocumentFields(array $documentData): void
    {
        $I = $this->tester;
        $I->needPage(Url::to('@document/create'));

        (new Select2($I, '#document-client'))
                ->setValue($documentData['client']);
        (new Input($I, '#document-title'))
                ->setValue($documentData['title']);
        (new Select2($I, '#document-sender_id'))
                ->setValue($documentData['sender']);
        (new Select2($I, '#document-receiver_id'))
                ->setValue($documentData['receiver']);
        (new Select2($I, '#document-type'))
                ->setValue($documentData['type']);
        (new Dropdown($I, '#document-class'))
                ->setValue($documentData['class']);
        (new Select2($I, '#document-object_id'))
                ->setValue($documentData['objectId']);
    }

    public function containsBlankFieldsError(array $fieldsList): void
    {
        foreach ($fieldsList as $field) {
            $this->tester->waitForText("$field cannot be blank.");
        }
    }

    public function dontContainsBlankFieldsError(array $fieldsList): void
    {
        foreach ($fieldsList as $field) {
            $this->tester->dontSee("$field cannot be blank.");
        }
    }
}
