<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\contacts;

use Codeception\Example;
use Facebook\WebDriver\Exception\InvalidElementStateException;
use hipanel\modules\client\tests\_support\Page\contact\Create;
use hipanel\tests\_support\Step\Acceptance\Admin;
use yii\helpers\Url;

class CreatePageCest
{
    /**
     * @dataProvider testContactData
     */
    public function ensureICanSetEntityDataWithPassport(Admin $I, Example $data): void
    {
        $createPage = new Create($I);
        $I->needPage(Url::to('@contact/create'));
        $I->see('Create contact', 'button');
        $I->executeJS('scroll(0,1000);');
        $createPage->fillFormData($data['passport']);
        $I->click('#legal-entity-box button.btn-box-tool');
        $I->expectThrowable(InvalidElementStateException::class, fn() => $createPage->fillFormData($data['entity']));
        $I->reloadPage();
    }

    /**
     * @dataProvider testContactData
     */
    public function ensureICanSetPassportDataWithEntity(Admin $I, Example $data): void
    {
        $createPage = new Create($I);
        $I->needPage(Url::to('@contact/create'));
        $I->see('Create contact', 'button');
        $I->executeJS('scroll(0,1000);');
        $createPage->fillFormData($data['organization']);
        $I->executeJS('scroll(0,2000);');
        $I->click('#legal-entity-box button.btn-box-tool');
        $createPage->fillFormData($data['entity']);
        $I->click('#passport-data-box button.btn-box-tool');
        $I->expectThrowable(InvalidElementStateException::class, fn() => $createPage->fillFormData($data['passport']));
    }

    protected function testContactData(): iterable
    {
        yield [
            'organization' => [
                'inputs' => [
                    'organization' => 'HiQDev',
                ],
            ],
            'passport' => [
                'inputs' => [
                    'birth_date' => '2000-12-12',
                    'passport_no' => '23213',
                    'passport_date' => '2001-12-12',
                    'passport_by' => 'test test',
                ],
            ],
            'entity' => [
                'inputs' => [
                    'organization_ru' => '2000-12-12',
                    'director_name' => '23213',
                    'inn' => '2001-12-12',
                    'kpp' => 'test test',
                ],
                'checkboxes' => [
                    'isresident' => true,
                ],
            ],
        ];
    }
}
