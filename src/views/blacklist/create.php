<?php
/**
 * Client module for HiPanel.
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

use hipanel\helpers\Url;
use hipanel\modules\client\helpers\blacklist\BlacklistCategoryInterface;
use hipanel\modules\client\models\Blacklist;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $action
 * @var array $types
 * @var Blacklist $model
 * @var BlacklistCategoryInterface $blacklistCategory
 */
$this->title = Yii::t('hipanel:client', sprintf('Create %s item', $blacklistCategory->getLabel()));
$this->params['breadcrumbs'][] = ['label' => Yii::t('hipanel', $blacklistCategory->getLabel()), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'contact-form',
    'enableAjaxValidation' => true,
    'layout' => 'horizontal',
    'validationUrl' => Url::toRoute(['validate-form', 'scenario' => $model->scenario]),
]) ?>

<?= $this->render('_form', ['model' => $model, 'types' => $types, 'form' => $form, 'blacklistCategory' => $blacklistCategory]) ?>

<?php if ($model->scenario === 'create') : ?>
    <?= Html::submitButton(Yii::t('hipanel:client', sprintf('Create %s item', $blacklistCategory->getLabel())), ['class' => 'btn btn-success']) ?>
<?php else : ?>
    <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-success']) ?>
<?php endif; ?>

<?= Html::button(Yii::t('hipanel', 'Cancel'), ['class' => 'btn btn-default', 'onclick' => 'history.go(-1)']) ?>

<?php ActiveForm::end() ?>
