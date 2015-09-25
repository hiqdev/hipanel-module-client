<?php

use hipanel\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'mailing-settings';

?>

<?php Modal::begin([
    'id' => $model->scenario . '_id',
    'size' => Modal::SIZE_LARGE,
    'header' => Html::tag('h4', Yii::t('app', 'Mailing settings'), ['class' => 'modal-title']),
    'toggleButton' => [
        'tag' => 'a',
        'label' => '<i class="ion-at"></i>' . Yii::t('app', 'Mailing settings'),
        'class' => 'clickable',
    ],
]); ?>
    Comming soon...
<?php Modal::end(); ?>