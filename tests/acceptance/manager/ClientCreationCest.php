<?php

namespace hipanel\modules\client\tests\acceptance\manager;

use Codeception\Example;
use hipanel\helpers\Url;
use hipanel\modules\client\tests\_support\Page\client\Create;
use hipanel\tests\_support\Step\Acceptance\Manager;

class ClientCreationCest
{
    private $existingClient;

    public function ensureClientCreationPageWorks(Manager $I): void
    {
        $I->login();
        $I->needPage(Url::to('@client'));
    }

    /**
     * @dataProvider provideValidClientData
     * @param Manager $I
     * @param Example $clientData
     * @throws \Exception
     */
    public function ensureICanCreateNewClient(Manager $I, Example $clientData): void
    {
        (new Create($I))->createValidClient($clientData);
    }

    /**
     * Returns array of valid information for each type of client
     *
     * @return array
     */
    protected function provideValidClientData(): array
    {
        $clientData = [];

        foreach (['client', 'reseller', 'manager', 'admin', 'support'] as $type) {
            $clientData[] = [
                'login'     => 'test_login' . uniqid(),
                'email'     => 'test_email@test.test' . uniqid(),
                'password'  => 'test_pass',
                'type'      =>  $type,
                'referer'   => 'websol',
                'reseller'  => 'domovoy'
            ];
        }

        $this->existingClient = $clientData[0];

        return $clientData;
    }

    public function ensureICantCreateClientWithoutAllRequiredData(Manager $I): void
    {
        (new Create($I))->createEmptyDataClient();
    }

    public function ensureICantCreateClientWithExistingData(Manager $I): void
    {
        (new Create($I))->createExistingClient($this->existingClient);
    }
}