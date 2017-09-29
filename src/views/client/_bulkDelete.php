<?php

use hipanel\widgets\BulkOperation;

echo BulkOperation::widget([
    'model' => $model,
    'models' => $models,
    'scenario' => 'delete',
    'affectedObjects' => Yii::t('hipanel:client', 'Affected clients'),
    'formatterField' => 'client',
    'hiddenInputs' => ['id', 'client'],
    'submitButton' => Yii::t('hipanel', 'Delete'),
    'submitButtonOptions' => ['class' => 'btn btn-danger'],
]);

