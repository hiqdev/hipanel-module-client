<?php

namespace hipanel\modules\client\helpers;

use hipanel\modules\client\models\Client;
use yii\caching\CacheInterface;
use yii\web\User;

/**
 * Class HasPINCode
 *
 * @author Andrey Klochok <andrey.klochok@gmail.com>
 */
class HasPINCode
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var User
     */
    private $user;

    public function __construct(CacheInterface $cache, User $user)
    {
        $this->cache = $cache;
        $this->user = $user;
    }

    public function __invoke(): bool
    {
        return $this->cache->getOrSet(['user-pincode-enabled', $this->user->id], function () {
            $pincodeData = Client::perform('has-pincode', ['id' => $this->user->id]);

            return (bool)$pincodeData['pincode_enabled'];
        }, 3600);
    }
}
