<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */
namespace hipanel\modules\client\tests\_support\Page\contact;

class Create extends FormPage
{
    /**
     * @return string
     */
    public function seeContactWasCreated(): string
    {
        $I = $this->tester;
        $I->closeNotification('Contact was created');
        $I->seeInCurrentUrl('/client/contact/view?id=');

        return $I->grabFromCurrentUrl('~id=(\d+)~');
    }
}
