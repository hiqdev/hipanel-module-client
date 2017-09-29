<?php

use hipanel\widgets\BulkOperation;

echo BulkOperation::widget([
    'model' => $model,
    'models' => $models,
    'scenario' => 'disable-block',
    'affectedObjects' => Yii::t('hipanel:client', 'Affected clients'),
    'formatterField' => 'client',
    'hiddenInputs' => ['id', 'client'],
    'visibleInputs' => ['comment'],
    'submitButton' => Yii::t('hipanel', 'Disable block'),
    'submitButtonOptions' => ['class' => 'btn btn-danger'],
    'dropDownInputs' => ['type' => $blockReasons ],
]);

