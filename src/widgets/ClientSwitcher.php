<?php

namespace hipanel\modules\client\widgets;

use yii\base\Widget;
use yii\helpers\Url;

class ClientSwitcher extends Widget
{
    public $model;

    public function run()
    {
        $this->initClientScript();

        return $this->render('ClientSwitcher', ['model' => $this->model]);
    }

    protected function initClientScript()
    {
        $url = Url::to(['@client/view', 'id' => '']);
        $this->view->registerJs("
            $('#client-client_id').on('select2:select', function (e) {
                var selectedClientId = this.value;
                location.replace('{$url}' + selectedClientId);
            });
        ");
    }
}
