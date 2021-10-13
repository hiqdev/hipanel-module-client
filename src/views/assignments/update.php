<?php

/* @var $this yii\web\View */
/* @var $errorMassage string|null */
/* @var $model hipanel\modules\client\models\Client */

use yii\bootstrap\Alert;

$this->title = Yii::t('hipanel', 'Set assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if ($errorMassage === null) : ?>
    <?= $this->render('_form', compact('model', 'models', 'plans', 'profiles')) ?>
<?php else : ?>
    <?= Alert::widget([
        'body' => $errorMassage,
        'closeButton' => false,
        'options' => [
            'class' => 'alert-warning text-center',
            'style' => ['margin' => '0 auto', 'width' => '50%']
        ],
    ]) ?>
<?php endif ?>

