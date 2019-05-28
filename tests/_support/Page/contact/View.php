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

use hipanel\tests\_support\Page\Authenticated;

class View extends Authenticated
{
    public function clickAction(string $action): void
    {
        $selector = "//div[contains(@class, 'profile-usermenu')]//ul//" .
            "a[contains(text(), '{$action}')]";
        $this->tester->click($selector);
    }
}
