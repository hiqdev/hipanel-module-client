<?php

namespace hipanel\modules\client\models;

use hipanel\rbac\AuthManager;
use Yii;
use yii\base\BaseObject;

class Permission extends BaseObject
{
    public Client $client;

    protected AuthManager $manager;

    public int $clientId;

    public array $clientRoles = [];

    public function __construct(Client $client, $config = [])
    {
        $this->client = $client;
        $this->clientId = $client->id;
        $this->clientRoles = explode(',', $this->client->roles);
        $this->manager = Yii::$app->authManager;

        parent::__construct($config);
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

        foreach ($this->clientRoles as $roleName) {
            $assigned[$roleName] = $available[$roleName];
            unset($available[$roleName]);
        }

        return [
            'available' => $this->reduceToAllowed($available),
            'assigned' => $assigned,
        ];
    }

    public function reduceToAllowed(array $items = []): array
    {
        return array_filter($items,
            fn($group, $name) => (str_starts_with($name, 'deny:') && $this->manager->checkAccess(Yii::$app->user->id, substr($name, 5))) || $this->manager->checkAccess(Yii::$app->user->id, $name),
            ARRAY_FILTER_USE_BOTH
        );
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
