<?php
/* @var $this yii\web\View */
/* @var $model hipanel\modules\client\models\Client */

$this->title = Yii::t('hipanel', 'Set assignments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', compact('model', 'models', 'plans', 'profiles')); ?>
