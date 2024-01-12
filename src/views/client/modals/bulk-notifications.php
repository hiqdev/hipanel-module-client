<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/advancedhosters/hipanel-module-client
 * @package   hipanel-module-client
 * @license   proprietary
 * @copyright Copyright (c) 2015-2018, AdvancedHosters (http://advancedhosters.com/)
 */
use hipanel\widgets\BulkOperation;

echo BulkOperation::widget([
    'model' => $model,
    'models' => $models,
    'scenario' => 'create-notifications',
    'affectedObjects' => Yii::t('hipanel:client', 'Affected clients'),
    'formatterField' => 'client',
    'hiddenInputs' => ['id', 'client'],
    'submitButton' => Yii::t('hipanel', 'Send notification'),
    'submitButtonOptions' => ['class' => 'btn btn-danger'],
    'dropDownInputs' => ['template_id' => $templates],
]);
