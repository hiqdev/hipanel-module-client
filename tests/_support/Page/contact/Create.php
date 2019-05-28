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

use Codeception\Example;
use Exception;
use hipanel\tests\_support\Page\Authenticated;
use hipanel\tests\_support\Page\Widget\Input\Input;
use hipanel\tests\_support\Page\Widget\Input\Select2;


class Create extends Authenticated
{
    /**
     * @param Example|array $values
     * @throws Exception
     */
    public function fillFormData($values): void
    {
        $I = $this->tester;

        $this->choosePhoneCountry($values['phoneCountryCode']);

        foreach ($values['inputs'] as $type => $value) {
            (new Input($I, "input[id$=$type]"))->setValue($value);
        }

        (new Select2($I, 'select[id$=client_id]'))
            ->setValue($values['selects']['client']);

        (new Select2($I, "#contact-country"))
            ->setValue($values['selects']['country']);
    }

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

    public function seeErrorInAddress(): void
    {
        $I = $this->tester;

        $I->waitForText('Address should contain at most 60 characters.');
        $I->waitForText('Address 2 should contain at most 60 characters.');
        $I->waitForText('Address 3 should contain at most 60 characters.');
    }

    private function choosePhoneCountry(string $phoneCountryCode): void
    {
        $I = $this->tester;

        $I->click("//*[contains(@class, 'voice_phone')]//*[@class='flag-container']");
        $I->click("(//*[contains(@class, 'voice_phone')]" .
            "//*[contains(@data-country-code, '{$phoneCountryCode}')])[1]");
    }
}
