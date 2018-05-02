<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

use hipanel\models\Ref;
use hipanel\widgets\DatePicker;
use hipanel\widgets\SwitchInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$langs = ArrayHelper::map(hipanel\modules\client\models\Article::getApiLangs(), 'gl_key', 'gl_value');
$this->registerJs("$(function () {\$('#lang_tab a:first').tab('show');});", yii\web\View::POS_END, 'lng-tabpanel-options');
$modelReflacion = new \ReflectionClass(get_class($model));

?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'is_published')->widget(SwitchInput::class) ?>

    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'post_date')->widget(DatePicker::class, [
        'value' => date('d-M-Y', strtotime('+2 days')),
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map(Ref::find()->where(['gtype' => 'type,article'])->getList(false), 'gl_key', function ($l) {
        return ucfirst($l->gl_value);
    })); ?>

    <div role="tabpanel" style="margin-bottom: 25px;">

        <!-- Nav tabs -->
        <ul id="lang_tab" class="nav nav-tabs" role="tablist">
            <?php foreach ($langs as $code => $label) : ?>
                <?=Html::beginTag('li', ['role' => 'presentation'])?>
                    <?=Html::a($label, '#' . $code, ['role' => 'tab', 'data-toggle' => 'tab']); ?>
                <?=Html::endTag('li')?>
            <?php endforeach; ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach ([2867298 => 'ru', 2867299 => 'en'] as $id => $lng) : ?>
                <?=Html::beginTag('div', ['id' => $lng, 'role' => 'tabpanel', 'class' => 'tab-pane'])?>
                    <?= $form->field($model, "data[$id][html_title]")->label('Html Title'); ?>
                    <?= $form->field($model, "data[$id][html_keywords]")->label('Html Keywords'); ?>
                    <?= $form->field($model, "data[$id][title]")->label('Article Title'); ?>
                    <?= $form->field($model, "data[$id][short_text]")->textarea(['rows' => 6])->label('Short Text'); ?>
                    <?= $form->field($model, "data[$id][text]")->textarea(['rows' => 9])->label('Long Text'); ?>
                <?=Html::endTag('div')?>
            <?php endforeach; ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('hipanel', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php $form->end(); ?>
