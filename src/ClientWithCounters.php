<?php

namespace hipanel\modules\client;

use hipanel\modules\client\models\Client;
use yii\helpers\Inflector;
use yii\web\Application;
use Yii;

class ClientWithCounters
{
    private ?Client $client;

    private Application $app;

    public function __construct()
    {
        $this->app = Yii::$app;
    }

    private function initClientCounters(): void
    {
        $client = $this->app->cache->getOrSet([__CLASS__, __METHOD__, $this->app->user->identity->id], fn(): ?Client => Client::findOne([
            'id' => $this->app->user->identity->id,
            'with_tickets_count' => true,
            'with_domains_count' => Yii::getAlias('@domain', false) ? true : false,
            'with_servers_count' => true,
            'with_hosting_count' => true,
            'with_contacts_count' => true,
        ]), 180);
        $this->setClient($client);
    }

    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }

    public function getClient(): ?Client
    {
        if (empty($this->client)) {
            $this->initClientCounters();
        }

        return $this->client;
    }

    public function getWidgetData(string $entityName): array
    {
        return [
            'model' => $this->getClient(),
            'ownCount' => $this->getClient()->count[Inflector::pluralize($entityName)] ?? 0,
            'entityName' => $entityName,
        ];
    }
}
