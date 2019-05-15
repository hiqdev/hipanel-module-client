<?php

namespace hipanel\modules\client\tests\_support\Page\contact;

use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\CheckBox;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;

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

    /**
     * @param string $zoneId
     */
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
    public function showCreatedContactOnIndexPage($name)
    {
        $I = $this->tester;
        $filterInputSelector = "td input[name*=name]";

        $input = new Input($I, $filterInputSelector);
        (new IndexPage($I))->filterBy($input, $name);
    }
}
