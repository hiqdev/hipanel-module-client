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

use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\tests\_support\Step\Acceptance\Admin;
use yii\helpers\Url;

class CreatePageCest
{
    public function ensureCreatePageWorks(Admin $I): void
    {
        $I->needPage(Url::to('@contact'));
        $I->see('Create contact', 'button');
        $I->click('#passport-data-box button');
        $I->click('#legal-entity-box button');
    }
}
