<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use hipanel\modules\client\models\Client;
use hipanel\widgets\BlockModalButton;
use hipanel\widgets\SettingsModal;
use Yii;
use yii\helpers\Url;

class ClientDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    /**
     * @var Client
     */
    public $model;

    public function items()
    {
        $actions = ClientActionsMenu::create([
            'model' => $this->model,
        ])->items();

        $user = Yii::$app->user;
        $totp_enabled = $this->model->totp_enabled;

        $items = array_merge([
            [
                'label' => Yii::t('hipanel:client', 'You can change your avatar at Gravatar.com'),
                'icon' => 'fa-user', // 'fa-user-circle-o',
                'url' => 'http://gravatar.com',
                'linkOptions' => [
                    'target' => '_blank',
                ],
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel', 'Change password'),
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'change-password',
                ]),
                'encode' => false,
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => $totp_enabled ? Yii::t('hipanel:client', 'Disable two factor authorization') : Yii::t('hipanel:client', 'Enable two factor authorization'),
                'icon' => 'fa-shield',
                'url' => 'https://' . Yii::$app->params['hiam.site'] . Url::to(['/mfa/totp/' . ($totp_enabled ? 'disable' : 'enable'), 'back' => Url::to('', true)]),
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Temporary password'),
                    'icon' => 'fa-key fa-flip-horizontal fa-fw',
                    'scenario' => 'set-tmp-password',
                ]),
                'encode' => false,
                'visible' => $user->not($this->model->id) && $user->can('manage'),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Pincode settings'),
                    'icon' => 'fa-puzzle-piece fa-fw',
                    'scenario' => 'pincode-settings',
                ]),
                'encode' => false,
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'IP address restrictions'),
                    'icon' => 'fa-arrows-alt fa-fw',
                    'scenario' => 'ip-restrictions',
                ]),
                'encode' => false,
                'visible' => $user->is($this->model->id),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Notification settings'),
                    'icon' => 'fa-envelope fa-fw',
                    'scenario' => 'mailing-settings',
                ]),
                'encode' => false,
                'visible' => $this->model->type !== Client::TYPE_EMPLOYEE,
            ],
            [
                'label' => Yii::t('hipanel:client', 'Change contact information'),
                'icon' => 'fa-edit fa-fw',
                'url' => ['@contact/update', 'id' => $this->model->id],
                'encode' => false,
                'visible' => false,
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:client', 'Domain settings'),
                    'icon' => 'fa-globe fa-fw',
                    'scenario' => 'domain-settings',
                ]),
                'encode' => false,
                'visible' => Yii::getAlias('@domain', false),
            ],
            [
                'label' => SettingsModal::widget([
                    'model' => $this->model,
                    'title' => Yii::t('hipanel:ticket', 'Ticket settings'),
                    'icon' => 'fa-ticket fa-fw',
                    'scenario' => 'ticket-settings',
                ]),
                'encode' => false,
                'visible' => Yii::getAlias('@ticket', false) && $this->model->type !== Client::TYPE_EMPLOYEE,
            ],
            [
                'label' => BlockModalButton::widget(['model' => $this->model]),
                'encode' => false,
                'visible' => $user->can('support') && $user->not($this->model->id),
            ]
        ], $actions);

        unset($items['view']);

        return $items;
    }
}
