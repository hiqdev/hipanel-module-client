<?php

use hipanel\modules\finance\models\PlanType;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $errorMassage string|null */
/* @var $model hipanel\modules\client\models\Client */
/* @var $models hipanel\modules\client\models\Client[] */
/* @var $profiles array */
/* @var $planTypes PlanType[] */
/* @var $plansByType [] */

$this->title = Yii::t('hipanel', 'Set assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if ($errorMassage === null) : ?>
    <?= $this->render('_form', ['plansByType' => $plansByType, 'model' => $model, 'models' => $models, 'profiles' => $profiles, 'planTypes' => $planTypes]) ?>
<?php else : ?>
    <?= Alert::widget([
        'body' => $errorMassage,
        'closeButton' => false,
        'options' => [
            'class' => 'alert-warning text-center',
            'style' => ['margin' => '0 auto', 'width' => '50%'],
        ],
    ]) ?>
<?php endif ?>

