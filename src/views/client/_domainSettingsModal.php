<?php

use hipanel\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$model->scenario = 'domain-settings';

?>

<?php Modal::begin([
    'id' => $model->scenario . '_id',
    'size' => Modal::SIZE_DEFAULT,
    'header' => Html::tag('h4', Yii::t('app', 'Domain settings'), ['class' => 'modal-title']),
    'toggleButton' => [
        'tag' => 'a',
        'label' => '<i class="fa fa-globe"></i>' . Yii::t('app', 'Domain settings'),
        'class' => 'clickable',
    ],
]); ?>
Comming soon...
<?php Modal::end(); ?>
