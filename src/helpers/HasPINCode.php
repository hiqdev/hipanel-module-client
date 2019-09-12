<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\helpers;

use hipanel\modules\client\models\Client;
use Yii;
use yii\caching\CacheInterface;
use yii\web\User;

/**
 * Class HasPINCode.
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

            return $this->isPincodeEnabled($pincodeData);
        }, 3600);
    }

    private function isPincodeEnabled(array $pincodeData): bool
    {
        return (bool) $pincodeData['pincode_enabled'] && $this->user->can('support') && Yii::$app->params['pincode.forced'] !== false;
    }
}
