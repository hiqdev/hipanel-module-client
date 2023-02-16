<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\menus;

use hipanel\helpers\Url;
use hipanel\menus\AbstractDetailMenu;
use hipanel\modules\client\models\Contact;
use hipanel\widgets\AjaxModal;
use Yii;
use yii\bootstrap\Modal;
use yii\helpers\Html;

class ContactDetailMenu extends AbstractDetailMenu
{
    public Contact $model;

    public function items()
    {
        $user = Yii::$app->user;
        $items = ContactActionsMenu::create([
            'model' => $this->model,
        ])->items();

        if (Yii::getAlias('@document', false)) {
            $items[] = [
                'label' => Yii::t('hipanel:client', 'Documents'),
                'icon' => 'fa-paperclip',
                'url' => ['attach-documents', 'id' => $this->model->id],
            ];
        }

        $items[] = [
            'label' => Yii::t('hipanel:client', 'Used for {n, plural, one{# domain} other{# domains}}', ['n' => (int) $this->model->used_count]),
            'icon' => 'fa-globe',
            'url' => Url::toSearch('domain', ['contacts' => $this->model->id]),
            'visible' => Yii::getAlias('@domain', false) && (int) $this->model->used_count > 0,
        ];
        $items = array_merge($items, [
            [
                'label' => AjaxModal::widget([
                    'id' => 'set-templates-modal',
                    'header' => Html::tag('h4', Yii::t('hipanel:finance', 'Set templates') . ': ' . Html::tag('b', "{$this->model->name} / {$this->model->organization}"), ['class' => 'modal-title']),
                    'scenario' => 'set-templates',
                    'actionUrl' => ['@requisite/bulk-set-templates', 'id' => $this->model->id],
                    'size' => Modal::SIZE_LARGE,
                    'toggleButton' => [
                        'label' => '<i class="fa fa-fw fa-exchange"></i>' . Yii::t('hipanel:finance', 'Set templates'),
                        'class' => 'clickable',
                        'data-pjax' => 0,
                        'tag' => 'a',
                    ],
                ]),
                'encode' => false,
                'visible' => $user->can('requisites.update'),
            ],
        ]);

        unset($items['view']);

        return $items;
    }
}
