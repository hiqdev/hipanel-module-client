<?php

$this->title = Yii::t('app', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Client'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \hipanel\widgets\Box::begin() ?>
    <?= $this->render('_form', ['model' => $model]); ?>
<?php \hipanel\widgets\Box::end() ?>

