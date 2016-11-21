<?php

namespace hipanel\modules\client\menus;

use hipanel\helpers\Url;
use hiqdev\menumanager\Menu;
use Yii;

class ContactDetailMenu extends Menu
{
    public $model;

    public function items()
    {
        $actions = ContactActionsMenu::create([
            'model' => $this->model,
        ])->items();
        $items = array_merge($actions, [
            [
                'label' => Yii::t('hipanel:client', 'Documents'),
                'icon' => 'fa-paperclip',
                'url' => ['attach-files', 'id' => $this->model->id],
            ],
            [
                'label' => Yii::t('hipanel:client', 'Used for {n, plural, one{# domain} other{# domains}}', ['n' => (int) $this->model->used_count]),
                'icon' => 'fa-globe',
                'url' => Url::toSearch('domain', ['client_id' => $this->model->client_id]),
                'visible' => Yii::getAlias('@domain', false) && (int) $this->model->used_count > 0,
            ]
        ]);
        unset($items['view']);

        return $items;
    }
}
