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

use hipanel\helpers\Url;
use Yii;

class ContactDetailMenu extends \hipanel\menus\AbstractDetailMenu
{
    public $model;

    public function items()
    {
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

        unset($items['view']);

        return $items;
    }
}
