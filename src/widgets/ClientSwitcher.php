<?php

namespace hipanel\modules\client\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class ClientSwitcher extends Widget
{
    public $model;

    public function run()
    {
        if (!Yii::$app->user->can('support')) {
            return '';
        }

        $this->initClientScript();
        return $this->render('ClientSwitcher', ['model' => $this->model]);
    }

    protected function initClientScript()
    {
        $url = Url::to(['@client/view', 'id' => '']);
        $this->view->registerJs("
            $('.client-switcher select').on('select2:select', function (e) {
                var selectedClientId = this.value;
                window.location.href = '{$url}' + selectedClientId;
            });
        ");
    }
}
