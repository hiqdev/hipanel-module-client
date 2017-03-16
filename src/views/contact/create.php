<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */


use hipanel\helpers\Url;
use yii\bootstrap\ActiveForm;

/**
 * @var \yii\web\View $this
 * @var array $countries
 * @var \hipanel\modules\client\models\Contact $model
 */

$this->title = Yii::t('hipanel:client', 'Create contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', 'Contact'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'action' => $model->scenario === 'copy' ? Url::toRoute('create') : $model->scenario,
    'enableClientValidation' => true,
    'validateOnBlur' => true,
    'enableAjaxValidation' => true,
    'layout' => 'horizontal',
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

<?= $this->render('_form', compact('model', 'countries', 'form')); ?>

<?php ActiveForm::end() ?>
