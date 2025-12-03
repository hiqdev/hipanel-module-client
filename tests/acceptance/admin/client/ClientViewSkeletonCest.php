<?php declare(strict_types=1);
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\tests\acceptance\admin\client;

use hipanel\helpers\Url;
use hipanel\modules\client\Module;
use hipanel\tests\_support\Step\Acceptance\Admin;
use Yii;

class ClientViewSkeletonCest
{
    private ?Module $clientModule = null;

    public function _before(): void
    {
        /** @var Module $clientModule */
        $this->clientModule = Yii::$app->getModule('client');
    }

    public function ensureThatClientSkeletonPageVisible(Admin $I): void
    {
        $I->login();
        $I->needPage(Url::to(['@client/view', 'id' => $I->id]));
        $I->see('Client detailed information #' . $I->id);
        $I->see('admin', '.profile-user-role');
        $I->see('Client information');
        $I->see('Contact information');
        $menu = array_filter([
            ['text' => 'You can change your avatar at Gravatar.com'],
            ['text' => 'Change password'],
            $this->clientModule->twoFactorAuth ? ['text' => 'Enable two-factor authorization'] : null,
            ['text' => 'Pincode settings'],
            ['text' => 'IP address restrictions'],
            ['text' => 'Notification settings'],
            ['text' => 'Domain settings', 'visible' => Yii::getAlias('@domain', false)],
            ['text' => 'Financial settings'],
            ['text' => 'Ticket settings'],
        ]);
        foreach ($menu as $item) {
            if (isset($item['visible']) && $item['visible'] === false) {
                continue;
            }
            $I->see($item['text'], '.profile-usermenu');
        }
    }
}
