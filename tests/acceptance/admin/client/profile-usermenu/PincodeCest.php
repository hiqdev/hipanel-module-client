<?php

namespace hipanel\modules\client\tests\acceptance\admin\client\profile\usermenu;

use hipanel\tests\_support\Step\Acceptance\Admin;
use hipanel\helpers\Url;

class PincodeCest
{
    /**
     * @var array
     */
    private $views;

    /**
     * @var array
     */
    private $selector;

    /**
     * @var array
     */
    private $testData;

    private function fillData(Admin $I)
    {
        $this->views = [
            'pinOnMessages' => [],
            'pinOffMessages' => [],
            'pinOnskeleton' => [
                ['text' => 'Disable pincode', 'selector' => '//a[@data-toggle="tab"]'],
                ['text' => 'Forgot pincode?', 'selector' => '//a[@data-toggle="tab"]'],
                ['text' => 'Enter pincode',   'selector' => '.control-label'],
                ['text' => 'Save',            'selector' => 'button'],
                ['text' => 'Cancel',          'selector' => 'button'],
            ],
            'pinOffskeleton' => [
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
        ];

        $this->views['pinOnMessages'][] = <<<MSG
You have already set a PIN code. 
In order to disable it, enter your current PIN or the secret question.
MSG;

        $this->views['pinOffMessages'][] = <<<MSG
To further protect your account, you can install a pin code.
The following operations, Push domain, Obtaining an authorization code for a domain transfer,
Change the email address of the account's primary contact,
will be executed only when the correct PIN code is entered.
In order to be able to disable the pin code in the future,
it is required to ask an answer to a security question.
MSG;
        $this->views['pinOffMessages'][] = <<<MSG
In case you forget the PIN code or answer to a secret question,
you can disconnect the PIN code only through the support service!
(You will need to verify your account by providing a copy of the documents)
MSG;

        $this->selector = [
            'pin' => ['name' => "Client[{$I->id}][pincode]"],
            'questionMenu' => "//select[@name='Client[{$I->id}][question]']",
            'questionField' => "//input[@name='Client[{$I->id}][question]']",
            'answer' => ['name' => "Client[{$I->id}][answer]"],
        ];

        $this->testData = [
            'popupErrorsData' => [
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
                        'value' => ''
                    ],
                    'answer' => 'test answer',
                    'message' => 'wrong input: Question',
                ],
            ],
            'inputErrorsData' => [
                [
                    'pin' => '123',
                    'message' => 'Enter pincode should contain at least 4 characters.'
                ],
                [
                    'pin' => '12345',
                    'message' => 'Enter pincode should contain at most 4 characters.'
                ],
            ],
            'validData' => [
                'ownQuestion' => [
                    'pin' => '1234',
                    'question' => [
                        'selector' => "//select/option[@value='own']",
                        'own' => true,
                        'value' => 'test question'
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
                        'value' => 'What is your grandmother’s maiden name?'
                    ],
                    'answer' => 'test answer',
                ],
            ],
        ];
    }

    public function ensureThatPincodeWorks(Admin $I)
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $this->fillData($I);
        $this->testPopupErrors($I);
        $this->testPinInputErrors($I);
        $this->testPin($I, 'using pin');
        $this->testPin($I, 'using answer');
        $this->testViewPinOff($I);
        $this->testViewPinOn($I);
    }

    private function testPopupErrors(Admin $I)
    {
        foreach ($this->testData['popupErrorsData'] as $values) {
            $this->loadPincodeForm($I);
            $I->fillField($this->selector['pin'], $values['pin']);
            $I->fillField($this->selector['answer'], $values['answer']);
            $this->chooseQuestion($I, $values['question']);
            $I->click('Save');
            $this->closePopup($I, $values['message']);
        }
    }

    private function testPinInputErrors(Admin $I)
    {
        $this->loadPincodeForm($I);
        foreach ($this->testData['inputErrorsData'] as $values) {
            $I->fillField($this->selector['pin'], $values['pin']);
            $I->click('Save');
            $I->waitForText($values['message']);
        }
        $I->click('Cancel');
    }

    private function testPin($I, string $method)
    {
        foreach ($this->testData['validData'] as $datum) {
            $this->enablePin($I, $datum);
            $this->disablePin($I, $datum, $method);
        }
    }

    private function testViewPinOff(Admin $I)
    {
        $this->loadPincodeForm($I);
        foreach ($this->views['pinOffMessages'] as $message) {
            $I->see($message);
        }
        foreach ($this->views['pinOffskeleton'] as $item) {
            $I->see($item['text'], $item['selector']);
        }
        $I->click($this->selector['questionMenu']);
        foreach ($this->views['questions']['options'] as $option) {
            $I->see($option, $this->views['questions']['selector']);
        }
        $I->click('Cancel');
    }

    private function testViewPinOn(Admin $I)
    {
        $data = [
            $this->testData['validData']['ownQuestion'],
            $this->testData['validData']['selectedQuestion'],
        ];
        foreach ($data as $datum) {
            $this->enablePin($I, $datum);
            $this->loadPincodeForm($I);
            foreach ($this->views['pinOnMessages'] as $message) {
                $I->see($message);
            }
            foreach ($this->views['pinOnskeleton'] as $item) {
                $I->see($item['text'], $item['selector']);
            }
            $I->click('Forgot pincode?');
            $I->see($datum['question']['value']);
            $I->click('Cancel');
            $this->disablePin($I, $datum, 'using pin');
        }
    }

    private function enablePin(Admin $I, $datum)
    {
        $this->loadPincodeForm($I);
        $I->fillField($this->selector['pin'], $datum['pin']);
        $I->fillField($this->selector['answer'], $datum['answer']);
        $this->chooseQuestion($I, $datum['question']);
        $I->click('Save');
        $this->closePopup($I, 'Pincode settings were updated');
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
        $I->click('Save');
        $this->closePopup($I, 'Pincode settings were updated');
    }

    private function loadPincodeForm(Admin $I)
    {
        $I->click('Pincode settings');
        $I->waitForElement('#pincode-settings-form', 120);
    }

    private function closePopup(Admin $I, string $text)
    {
        $I->waitForElement('.ui-pnotify', 180);
        $I->see($text, '.ui-pnotify');
        $I->moveMouseOver(['css' => '.ui-pnotify']);
        $I->wait(1);
        $I->click('//span[@title="Close"]');
    }

    private function chooseQuestion(Admin $I, $question)
    {
        if ($question) {
            $I->click($this->selector['questionMenu']);
            $I->click($question['selector']);
            if ($question['own']) {
                $I->fillField($this->selector['questionField'], $question['value']);
            }
        }
    }
}
