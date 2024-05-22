<?php declare(strict_types=1);
/**
 * Client module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

use hipanel\helpers\Url;
use hipanel\modules\client\models\Contact;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Inflector;

/**
 * @var array $countries
 * @var boolean $askPincode
 * @var Contact $model
 * @var string $action
 */

$this->title = Yii::t('hipanel', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel:client', 'Blacklists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => Inflector::titleize($model->name, true),
    'url' => ['view', 'id' => $model->id],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableAjaxValidation' => true,
    'layout' => 'horizontal',
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

<?= $this->render('_form', ['model' => $model, 'types' => [], 'form' => $form]) ?>

<?php if ($model->scenario === 'create') : ?>
    <?= Html::submitButton(Yii::t('hipanel:client', 'Create blacklist'), ['class' => 'btn btn-success']) ?>
<?php else : ?>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
<?php endif; ?>

<?php ActiveForm::end() ?>
