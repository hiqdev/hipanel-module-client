<?php

namespace hipanel\modules\client\models;

use hipanel\rbac\AuthManager;
use RuntimeException;
use Yii;
use yii\base\BaseObject;

class Permission extends BaseObject
{
    public Client $client;

    protected AuthManager $manager;

    public int $clientId;

    public function __construct(Client $client, $config = [])
    {
        $this->client = $client;
        $this->clientId = $client->id;
        $this->manager = Yii::$app->authManager;
        $this->manager->setAssignments($client->roles, $client->id);

        parent::__construct($config);
    }

    public function assign(array $items): bool
    {
        throw new RuntimeException('not implemented');
    }

    public function revoke(array $items): bool
    {
        throw new RuntimeException('not implemented');
    }

    public function getItems(): array
    {
        $available = [];
        $assigned = [];

        foreach (array_keys($this->manager->getRoles()) as $name) {
            $available[$name] = 'role';
        }

        foreach (array_keys($this->manager->getPermissions()) as $name) {
            if ($name[0] !== '/') {
                $available[$name] = 'permission';
            }
        }

        foreach ($this->manager->getAssignments($this->clientId) as $item) {
            $assigned[$item->roleName] = $available[$item->roleName];
            unset($available[$item->roleName]);
        }

        return [
            'available' => $available,
            'assigned' => $assigned,
        ];
    }

    public function getChildren(): array
    {
        return $this->manager->getAllChildren();
    }

    public function getRoles(): array
    {
        return $this->manager->getRoles();
    }

    public function getPermissions(): array
    {
        return $this->manager->getPermissions();
    }
}
