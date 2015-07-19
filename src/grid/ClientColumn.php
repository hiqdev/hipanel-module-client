<?php

/*
 * Client Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2015, HiQDev (https://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\DataColumn;
use hipanel\modules\client\widgets\combo\ClientCombo;
use yii\helpers\Html;

class ClientColumn extends DataColumn
{
    public $attribute = 'client_id';

    public $nameAttribute = 'client';

    public $format = 'html';

    /**
     * @var string the combo type. Available: `client` or `seller`
     */
    public $clientType;

    public function init()
    {
        parent::init();
        if (is_null($this->visible)) {
            $this->visible = \Yii::$app->user->identity->type !== 'client';
        };
        if (!empty($this->grid->filterModel)) {
            if (!$this->filterInputOptions['id']) {
                $this->filterInputOptions['id'] = $this->attribute;
            }
            if (!$this->filter) {
                $this->filter = ClientCombo::widget([
                    'attribute'           => $this->attribute,
                    'model'               => $this->grid->filterModel,
                    'formElementSelector' => 'td',
                    'clientType'          => $this->clientType,
                ]);
            };
        };
    }

    public function getDataCellValue($model, $key, $index)
    {
        return Html::a($model->{$this->nameAttribute}, ['/client/client/view', 'id' => $model->{$this->attribute}]);
    }
}
