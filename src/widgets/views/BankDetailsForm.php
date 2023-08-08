<?php

use hipanel\modules\client\models\BankDetails;
use hipanel\modules\client\models\Contact;
use hipanel\modules\finance\models\Requisite;
use hipanel\widgets\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var ActiveForm $form
 * @var Requisite|Contact $parentModel
 * @var BankDetails[] $models
 * @var array $currencies
 * @var int $requisiteId
 */

$selector = "df_bd_$parentModel->id";
$this->registerJs(<<<"JS"
;(() => {
  const container = $(".$selector");
  container.on("afterInsert", function(ev, item) {
    $(":input[name*='requisite_id']", item).val("$parentModel->id");
  });
  container.on("click", ".btn-default", function(ev) {
    ev.preventDefault();

    const newDefaultInput = $(":input[name$='no]']", $(ev.currentTarget).closest(".item"));
    const oldDefaultInput = $(`:input[value='0']`, container);
    oldDefaultInput.val(newDefaultInput.val());
    newDefaultInput.val("0");

    $(".btn-default:hidden", container).toggle();
    $(ev.currentTarget).toggle();
  });
})();
JS
);

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => $selector, // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 99, // the maximum times, an element can be cloned (default 999)
//    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => reset($models),
    'formId' => $form->id,
    'formFields' => [
        'no',
        'currency',
        'bank_account',
        'bank_name',
        'bank_address',
        'bank_swift',
        'bank_correspondent',
        'bank_correspondent_swift',
    ],
]) ?>

<div class="box box-widget">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Yii::t('hipanel:client', 'Bank details') ?></h3>
        <button type="button" class="btn btn-success btn-xs add-item pull-right">
            <i class="fa fa-plus"></i>
            <?= Yii::t('hipanel:client', 'Add bank details') ?>
        </button>
    </div>

    <div class="container-items">

        <?php foreach ($models as $idx => $model) : ?>
            <div class="item">
                <div class="box-body">
                    <?php if (!$model->isNewRecord) : ?>
                        <?= Html::activeHiddenInput($model, "[$idx]id") ?>
                    <?php endif ?>
                    <?= Html::activeHiddenInput($model, "[$idx]no", ['value' => $idx]) ?>
                    <?= Html::activeHiddenInput($model, "[$idx]requisite_id", ['value' => $parentModel->id]) ?>
                    <?= $form->field($model, "[$idx]currency")->dropDownList($currencies, ['prompt' => '--']) ?>
                    <?= $form->field($model, "[$idx]bank_account")->textarea(['rows' => 5]) ?>
                    <?= $form->field($model, "[$idx]bank_name") ?>
                    <?= $form->field($model, "[$idx]bank_address") ?>
                    <?= $form->field($model, "[$idx]bank_swift") ?>
                    <?= $form->field($model, "[$idx]bank_correspondent") ?>
                    <?= $form->field($model, "[$idx]bank_correspondent_swift") ?>
                </div>
                <div class="box-footer text-center" style="background-color: rgba(221,75,57,0.11);">
                    <div class="btn-group btn-group-justified" role="group">
                        <a class="btn btn-danger btn-xs remove-item">
                            <i class="fa fa-trash-o"></i>
                            <?= Yii::t('hipanel', 'Remove') ?>
                        </a>
                        <?= Html::a(Yii::t('hipanel:client', 'Set as default'), null, [
                            'class' => ['btn', 'btn-default', 'btn-xs'],
                            'style' => ['display' => $model->no === 0 ? 'none' : 'table-cell'],
                        ]) ?>
                    </div>
                </div>
                <?php if (next($models)) : ?>
                    <div class="box-footer" style="background-color: #ecf0f5; padding: .5rem;"></div>
                <?php endif ?>
            </div>
        <?php endforeach ?>

    </div>

</div>

<?php DynamicFormWidget::end(); ?>
