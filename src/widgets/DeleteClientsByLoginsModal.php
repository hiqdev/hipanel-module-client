<?php

declare(strict_types=1);

namespace hipanel\modules\client\widgets;

use hipanel\modules\client\forms\DeleteClientsByLoginsForm;
use Yii;
use yii\base\Widget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

class DeleteClientsByLoginsModal extends Widget
{
    public function init(): void
    {
        $this->view->on(View::EVENT_END_BODY, function () {
            $model = new DeleteClientsByLoginsForm();
            Modal::begin([
                'id' => $this->getId(),
                'header' => Html::tag('h4', Yii::t('hipanel:client', 'Delete by logins'), ['class' => 'modal-title']),
                'toggleButton' => false,
            ]);

            $form = ActiveForm::begin([
                'action' => Url::to(['@client/delete-by-logins']),
            ]);

            echo $form->field($model, 'logins')->textarea()->hint(Yii::t('hipanel:client', 'Type client logins, delimited with a space, comma or a new line'));
            echo Html::submitButton(Yii::t('hipanel:client', 'Delete clients'), ['class' => 'btn btn-danger btn-block']);

            ActiveForm::end();

            Modal::end();
        });
    }

    public function run(): string
    {
        if (!Yii::$app->user->can('client.delete')) {
            return '';
        }
        $this->view->registerCss(".box-bulk-actions { display: flex; } .box-bulk-actions > button { margin-right: .3rem; }");

        return Html::button(Yii::t('hipanel:client', 'Delete by logins'), [
            'data' => ['toggle' => 'modal', 'target' => '#' . $this->getId()],
            'class' => 'btn btn-danger btn-sm',
        ]);
    }
}
