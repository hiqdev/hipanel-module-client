<?php

use hipanel\modules\client\widgets\combo\ClientCombo;
use yii\bootstrap\ActiveForm;

?>
<?php $form = ActiveForm::begin() ?>
<?= $form->field($model, 'client_id')->widget(ClientCombo::class, [
    'inputOptions' => [
        'data' => [
            'allow-clear' => 'false'
        ]
    ]
])->label(false) ?>
<?php ActiveForm::end(); ?>
