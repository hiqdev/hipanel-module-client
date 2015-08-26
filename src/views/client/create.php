<?php

use hipanel\widgets\Box;

$this->title = Yii::t('app', 'Create Client');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Client'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php Box::begin() ?>
    <?= $this->render('_form', ['model' => $model]) ?>
<?php Box::end() ?>
