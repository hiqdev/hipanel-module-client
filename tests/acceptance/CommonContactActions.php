<?php

namespace hipanel\modules\client\tests\acceptance;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\AcceptanceTester;
use hipanel\modules\client\tests\_support\Page\contact\Create;
use hipanel\modules\client\tests\_support\Page\contact\Update;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;


abstract class CommonContactActions
{
    protected array $createdContacts;

    abstract protected function testContactData(): array;

    /**
     * @param AcceptanceTester $I
     * @param Example $data
     * @throws \Exception
     */
    protected function create(AcceptanceTester $I, Example $data): void
    {
        $createPage = new Create($I);
        $I->needPage(Url::to('@contact/create'));
        $I->see('Create contact', 'h1');
        $createPage->fillFormData($data);
        $I->click('Create contact');
        $I->waitForPageUpdate();
        $contactId = $createPage->seeContactWasCreated();
        $this->createdContacts[$contactId] = $data['inputs']['first_name'];
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    protected function update(AcceptanceTester $I, Example $data): void
    {
        $indexPage = new IndexPage($I);
        $updatePage = new Update($I);

        foreach ($this->createdContacts as $id => $name) {
            $I->needPage(Url::to('@contact'));

            $indexPage->gridView->filterBy(Input::asTableFilter($I, 'Name'), $name);
            $indexPage->gridView->openRowMenuById($id);
            $indexPage->gridView->chooseRowMenuOption('Edit');

            $updatePage->fillFormData($data);
            $I->pressButton('Save');
            $I->wait(0.5);
            $updatePage->sendPincode($I, $data['pincode']);
            $I->closeNotification('Contact was updated');
        }
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Exception
     */
    protected function createIncorrect(AcceptanceTester $I): void
    {
        $createPage = new Create($I);
        $I->needPage(Url::to('@contact/create'));
        $testContact = $this->testContactData()[0];
        $testContact['inputs']['street1'] = str_repeat('1', 65);
        $testContact['inputs']['street2'] = str_repeat('2', 65);
        $testContact['inputs']['street3'] = str_repeat('3', 65);
        $createPage->fillFormData($testContact);
        $I->click('Create contact');
        $createPage->seeErrorInAddress();
    }

    /**
     * @param AcceptanceTester $I
     * @throws \Codeception\Exception\ModuleException
     */
    protected function delete(AcceptanceTester $I): void
    {
        $indexPage = new IndexPage($I);

        foreach ($this->createdContacts as $id => $name) {
            $I->needPage(Url::to('@contact'));
            $indexPage->gridView->filterBy(
                Input::asTableFilter($I, 'Name'), $name
            );
            $indexPage->gridView->selectRowById($id);
            $I->pressButton('Delete');
            $I->acceptPopup();
            $I->closeNotification('Contact was deleted');
        }
    }
}
