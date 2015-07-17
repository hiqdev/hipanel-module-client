<?php
/**
 * @link    http://hiqdev.com/hipanel-module-client
 * @license http://hiqdev.com/hipanel-module-client/license
 * @copyright Copyright (c) 2015 HiQDev
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hipanel\modules\client\models\Mailing */
/* @var $form ActiveForm */
?>
<div class="client-mailing-index">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'from') ?>
    <?= $form->field($model, 'subject') ?>
    <?= $form->field($model, 'message')->textarea(['rows'=>6]) ?>
    <?= $form->field($model, 'types')->dropDownList(['newsletters'=>'Newsletters','commercial'=>'Commercial']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- client-mailing-index -->
