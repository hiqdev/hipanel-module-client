<?php

namespace hipanel\modules\client\tests\_support\Page\contact;

use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\CheckBox;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use WebDriverKeys;


class Index extends Authenticated
{
    public function ensureICanSeeAdvancedSearchBox(): void
    {
        $I = $this->tester;
        (new IndexPage($I))->containsFilters([
            Input::asAdvancedSearch($I, 'Name'),
            Input::asAdvancedSearch($I, 'Email'),
            Select2::asAdvancedSearch($I, 'Client'),
            Select2::asAdvancedSearch($I, 'Reseller'),
        ]);
    }

    public function ensureICanSeeBulkSearchBox(): void
    {
        $I = $this->tester;
        (new IndexPage($I))->containsBulkButtons([
            'Delete',
        ]);
        (new IndexPage($I))->containsColumns([
            'Name',
            'Email',
            'Client',
            'Reseller',
        ], 'Common');
        (new IndexPage($I))->containsColumns([
            'Name',
            'Requisites',
        ], 'Requisites');
    }

    public function checkBoxClick(string $zoneId): void
    {
        $I = $this->tester;
        $checkBoxSelector = "input[type=checkbox][value='$zoneId']";
        (new CheckBox($I, $checkBoxSelector))
            ->setValue('1');
    }

    /**
     * @param $name
     * @throws \Codeception\Exception\ModuleException
     */
    public function getCreatedContactOnIndexPage($name)
    {
        $I = $this->tester;
        $sortinputSelector = "td input[name*=name]";
        (new Input($I, $sortinputSelector))
            ->setValue($name);
        $I->pressKey($sortinputSelector, WebDriverKeys::ENTER);
        $I->waitForPageUpdate();
    }
}
