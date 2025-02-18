<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\tests\_support\Step\Acceptance\Admin;

class PincodeCest
{
    /**
     * @var array
     */
    private $selector;

    public function _before(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $this->selector = [
            'pin' => ['name' => "Client[{$I->id}][pincode]"],
            'questionDropdownList' => "//select[@name='Client[{$I->id}][question]']",
            'questionField' => "//input[@name='Client[{$I->id}][question]']",
            'answer' => ['name' => "Client[{$I->id}][answer]"],
        ];
        $this->ensurePinIsDisabled($I);
    }

    private function ensurePinIsDisabled(Admin $I)
    {
        $this->loadPincodeForm($I);
        try {
            $I->waitForText('Disable pincode', 1);
            $I->click('Cancel');
            $this->disablePin($I, ['pin' => 1234], 'using pin');
        } catch (\Exception $e) {
            $I->click('Cancel');
        }
    }

    private function loadPincodeForm(Admin $I)
    {
        $I->click('Pincode settings');
        $I->waitForElement('#pincode-settings-form', 120);
    }

    private function savePincodeForm(Admin $I)
    {
        $I->click('Save');
        $I->closeNotification('Pincode settings were updated');
    }

    private function chooseQuestion(Admin $I, $question)
    {
        if ($question) {
            $I->click($this->selector['questionDropdownList']);
            $I->click($question['selector']);
            if ($question['own']) {
                $I->fillField($this->selector['questionField'], $question['value']);
            }
        }
    }

    /**
     * @dataProvider validValues
     * @param Admin $I
     * @param Example $example
     */
    public function testPincode(Admin $I, Example $example)
    {
        $this->enablePin($I, $example);
        $this->disablePin($I, $example, 'using pin');
        $this->enablePin($I, $example);
        $this->disablePin($I, $example, 'using answer');
    }

    private function validValues()
    {
        return [
            'ownQuestion' => [
                'pin' => '1234',
                'question' => [
                    'selector' => "//select/option[@value='own']",
                    'own' => true,
                    'value' => 'test question',
                ],
                'answer' => 'test answer',
            ],
            'defaultQuestion' => [
                'pin' => '1234',
                'question' => null,
                'answer' => 'test answer',
            ],
            'selectedQuestion' => [
                'pin' => '1234',
                'question' => [
                    'selector' => "//select/option[@value='What is your grandmother’s maiden name?']",
                    'own' => false,
                    'value' => 'What is your grandmother’s maiden name?',
                ],
                'answer' => 'test answer',
            ],
        ];
    }

    private function enablePin(Admin $I, $example)
    {
        $this->loadPincodeForm($I);
        $I->fillField($this->selector['pin'], $example['pin']);
        $I->fillField($this->selector['answer'], $example['answer']);
        $this->chooseQuestion($I, $example['question']);
        $this->savePincodeForm($I);
    }

    private function disablePin(Admin $I, $datum, string $method)
    {
        $this->loadPincodeForm($I);
        if ($method === 'using pin') {
            $I->fillField($this->selector['pin'], $datum['pin']);
        } elseif ($method === 'using answer') {
            $I->click('Forgot pincode?');
            $I->fillField($this->selector['answer'], $datum['answer']);
        }
        $this->savePincodeForm($I);
    }

    /**
     * @dataProvider providerPincodeData
     */
    public function testSetPincode(Admin $I, Example $pincodeInfo)
    {
        $this->enablePin($I, $pincodeInfo);
    }

    private function providerPincodeData()
    {
        return [
            [
                'pin' => '1234',
                'question' => null,
                'answer' => 'test answer',
            ]
        ];
    }
}
