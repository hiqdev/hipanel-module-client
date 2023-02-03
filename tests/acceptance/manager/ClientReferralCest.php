<?php
declare(strict_types=1);

namespace hipanel\modules\client\tests\acceptance\manager;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\modules\client\tests\_support\Helper\UserCreationHelper;
use hipanel\tests\_support\Step\Acceptance\Manager;
use hipanel\tests\_support\Page\Widget\Input\Select2;
use hipanel\modules\client\tests\_support\Page\client\Create;

class ClientReferralCest
{
    private UserCreationHelper $userCreationHelper;

    protected function _inject(UserCreationHelper $userCreationHelper): void
    {
        $this->userCreationHelper = $userCreationHelper;
    }

    public function _before(Manager $I, $scenario): void
    {
        if (!$this->userCreationHelper->canCreateUsers()) {
            $scenario->skip($this->userCreationHelper->getDisabledMessage());
        }
        $scenario->skip('Skip the referral test because this program is not in use');
    }

    private function getUserId(Manager $I): ?string
    {
        return $I->grabFromCurrentUrl('~(\d+)~');
    }

    /**
     * @dataProvider provideClientData
     */
    public function ensureRefferalProgramWorksCorrectly(Manager $I, Example $client): void
    {
        $I->login();
        $client = iterator_to_array($client->getIterator());

        $I->needPage(Url::to('@client'));

        $I->clickLink('Create client');
        $I->waitForPageUpdate();

        $referrerId = $this->enusreICanCreateTestReferrer($I, $client['referrer']);

        $I->needPage(Url::to('@client/create'));
        $this->createClient($I, $client['client']);
        $this->ensureReferralBoxWillNotBeCreatedForUser($I, $client['tariff']);

        $this->ensureReferralBoxNotCreated($I, $referrerId);

        $this->setReferralTariffPlan($I, $client['tariff']);
        $this->ensureReferralBoxCreated($I, $referrerId);

    }

    private function createClient(Manager $I, array $client): void
    {
        $I->seeInCurrentUrl('/create');

        $page = new Create($I);

        $page->fillClientData($client);

        $I->pressButton('Save');
        $I->waitForPageUpdate();

        $page->seeClientWasCreated($client['login'], $client['type']);
    }

    private function enusreICanCreateTestReferrer(Manager $I, array $client): ?string
    {
        $this->createClient($I, $client);

        $I->cantSee('Referrals', 'h4');

        return $this->getUserId($I);
    }

    private function setReferralTariffPlan(Manager $I, string $tariff): void
    {
        $I->clickLink('Enable referral program');

        $I->waitForElementVisible("//label[contains(text(),'Tariff')]");
        (new Select2($I, '#client-tariff_ids'))->setValue($tariff);
        $I->pressButton('Set tariff plan');
    }

    private function ensureReferralBoxNotCreated(Manager $I, string $id): void
    {
        $I->needPage("client/client/view?id=$id");

        $I->cantSee('Referrals', 'h4');
        $I->cantSee('Set referral tariff', 'button');
    }

    private function ensureReferralBoxWillNotBeCreatedForUser(Manager $I, string $tariff): void
    {
        $this->setReferralTariffPlan($I, $tariff);
        $this->ensureReferralBoxNotCreated($I, $this->getUserId($I));
    }

    private function ensureReferralBoxCreated(Manager $I, string $id): void
    {
        $I->needPage("client/client/view?id=$id");

        $I->see('Referrals', 'h4');
        $I->see('Set referral tariff', 'button');
    }

    protected function provideClientData(): array
    {
        $username = 'test_user' . uniqid();

        return [
            [
                'referrer' => [
                    'login'    => $username,
                    'email'    => $username . '@hiqdev.com',
                    'password' => 'random',
                    'type'     => 'reseller',
                    'reseller' => null,
                    'referer'  => null,
                ],
                'client'   => [
                    'login'    => $username . 'ref',
                    'email'    => $username . 'ref@hiqdev.com',
                    'password' => 'random',
                    'type'     => 'client',
                    'reseller' => null,
                    'referer'  => $username,
                ],
                'tariff'   => 'Test-Referral-01@hipanel_test_reseller',
            ]
        ];
    }
}
