<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
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
    }

    private function loadPincodeForm(Admin $I)
    {
        $I->click('Pincode settings');
        $I->waitForElement('#pincode-settings-form', 120);
    }

    private function closePincodeForm(Admin $I)
    {
        $I->click('Cancel');
    }

    private function savePincodeForm(Admin $I)
    {
        $I->click('Save');
        $I->closeNotification('Pincode settings were updated');
    }

    /**
     * @before loadPincodeForm
     * @dataProvider pnotifyErrorValues
     * @param Admin $I
     * @param Example $example
     */
    public function testPnotifyErrors(Admin $I, Example $example)
    {
        $I->fillField($this->selector['pin'], $example['pin']);
        $I->fillField($this->selector['answer'], $example['answer']);
        $this->chooseQuestion($I, $example['question']);
        $I->click('Save');
        $I->closeNotification($example['message']);
    }

    private function pnotifyErrorValues()
    {
        return [
            [
                'pin' => '',
                'question' => null,
                'answer' => 'test answer',
                'message' => 'no data given',
            ],
            [
                'pin' => '1234',
                'question' => null,
                'answer' => '',
                'message' => 'wrong input: Answer',
            ],
            [
                'pin' => '1234',
                'question' => [
                    'selector' => "//select/option[@value='own']",
                    'own' => true,
                    'value' => '',
                ],
                'answer' => 'test answer',
                'message' => 'wrong input: Question',
            ],
        ];
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
     * @before loadPincodeForm
     * @after closePincodeForm
     * @param Admin $I
     */
    public function testPinInputErrors(Admin $I)
    {
        $examples = $this->inputErrorValues();
        foreach ($examples as $example) {
            $this->fillInputError($I, $example['pin']);
            $I->see($example['message']);
            $this->fillInputError($I, '');
        }
    }

    private function fillInputError(Admin $I, string $pin)
    {
        $I->fillField($this->selector['pin'], $pin);
        $I->clickWithLeftButton("//div[@class='bg-info']");
        $operator = $pin !== '' ? '!==' : '===';
        $js = <<<JS
                return $("[name='{$this->selector['pin']['name']}']")
                .parent().find('p.help-block-error').text() {$operator} '';
JS;
        $I->waitForJS($js, 10);
    }

    private function inputErrorValues()
    {
        return [
            [
                'pin' => '123',
                'message' => 'Enter pincode should contain at least 4 characters.',
            ],
            [
                'pin' => '12345',
                'message' => 'Enter pincode should contain at most 4 characters.',
            ],
        ];
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

    public function testContentVisibility(Admin $I)
    {
        $content = $this->visibleContent();
        $values = $this->validValues();
        unset($values['defaultQuestion']);
        $this->testContentVisibilityWithPinOn($I, $content['pinOn'], $values);
        $this->testContentVisibilityWithPinOff($I, $content['pinOff']);
    }

    private function visibleContent()
    {
        $views = [
            'pinOn' => [
                'messages' => [],
                'skeleton' => [
                    ['text' => 'Disable pincode', 'selector' => '//a[@data-toggle="tab"]'],
                    ['text' => 'Forgot pincode?', 'selector' => '//a[@data-toggle="tab"]'],
                    ['text' => 'Enter pincode',   'selector' => '.control-label'],
                    ['text' => 'Save',            'selector' => 'button'],
                    ['text' => 'Cancel',          'selector' => 'button'],
                ],
            ],
            'pinOff' => [
                'messages' => [],
                'skeleton' => [
                    ['text' => 'Enter pincode',   'selector' => '.control-label'],
                    ['text' => 'Choose question', 'selector' => '.control-label'],
                    ['text' => 'Answer',          'selector' => '.control-label'],
                    ['text' => 'Save',            'selector' => 'button'],
                    ['text' => 'Cancel',          'selector' => 'button'],
                ],
                'questions' => [
                    'selector' => '//select/option',
                    'options' => [
                        'What was your nickname when you were a child?',
                        'What was the name of your best childhood friend?',
                        'What is the month and the year of birth of your oldest relative? (e.g. January, 1900)',
                        'What is your grandmother’s maiden name?',
                        'What is the patronymic of your oldest relative?',
                        'Own question',
                    ],
                ],
            ],
        ];
        $views['pinOn']['messages'][] = <<<MSG
You have already set a PIN code. 
In order to disable it, enter your current PIN or the secret question.
MSG;
        $views['pinOff']['messages'][] = <<<MSG
To further protect your account, you can install a pin code.
The following operations, Push domain, Obtaining an authorization code for a domain transfer,
Change the email address of the account's primary contact,
will be executed only when the correct PIN code is entered.
In order to be able to disable the pin code in the future,
it is required to ask an answer to a security question.
MSG;
        $views['pinOff']['messages'][] = <<<MSG
In case you forget the PIN code or answer to a secret question,
you can disconnect the PIN code only through the support service!
(You will need to verify your account by providing a copy of the documents)
MSG;

        return $views;
    }

    private function testContentVisibilityWithPinOn(Admin $I, $content, $values)
    {
        foreach ($values as $datum) {
            $this->enablePin($I, $datum);
            $this->loadPincodeForm($I);
            foreach ($content['messages'] as $message) {
                $I->see($message);
            }
            foreach ($content['skeleton'] as $item) {
                $I->see($item['text'], $item['selector']);
            }
            $I->click('Forgot pincode?');
            $I->see($datum['question']['value']);
            $I->click('Cancel');
            $this->disablePin($I, $datum, 'using pin');
        }
    }

    private function testContentVisibilityWithPinOff(Admin $I, $content)
    {
        $this->loadPincodeForm($I);
        foreach ($content['messages'] as $message) {
            $I->see($message);
        }
        foreach ($content['skeleton'] as $item) {
            $I->see($item['text'], $item['selector']);
        }
        $I->click($this->selector['questionDropdownList']);
        foreach ($content['questions']['options'] as $option) {
            $I->see($option, $content['questions']['selector']);
        }
        $this->closePincodeForm($I);
    }
}
