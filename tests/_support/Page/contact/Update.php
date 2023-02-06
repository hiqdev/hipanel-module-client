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

use hipanel\tests\_support\AcceptanceTester;
use hipanel\tests\_support\Page\Widget\Input\Input;

class Update extends FormPage
{
    public function sendPincode(AcceptanceTester $I, int $pincode): void
    {
        (new Input($I, 'input[name=pincode-modal-input]'))->setValue($pincode);
        $I->pressButton('Send');
    }
}
