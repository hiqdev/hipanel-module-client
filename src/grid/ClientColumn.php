<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\higrid\DataColumn;
use Yii;
use yii\helpers\Html;

class ClientColumn extends DataColumn
{
    public $idAttribute = 'client_id';

    public $attribute = 'client_id';

    public $nameAttribute = 'client';

    public $format = 'html';

    /**
     * @var string the combo type. Available: `client` or `seller`
     */
    public $clientType;

    /**
     * Sets visibility and default behaviour for value and filter when visible.
     */
    public function init()
    {
        parent::init();

        $this->visible = Yii::$app->user->can('support');
        if (!$this->visible) {
            return null;
        }

        if (!$this->sortAttribute) {
            $this->sortAttribute = $this->nameAttribute;
        }
        if ($this->value === null) {
            $this->value = function ($model) {
                if (Yii::$app->user->identity->hasSeller($model->{$this->idAttribute})) {
                    return $model->{$this->nameAttribute};
                } else {
                    return Html::a($model->{$this->nameAttribute}, ['@client/view', 'id' => $model->{$this->idAttribute}]);
                }
            };
        }
        if (!empty($this->grid->filterModel)) {
            if (!isset($this->filterInputOptions['id'])) {
                $this->filterInputOptions['id'] = $this->attribute;
            }
            if ($this->filter === null && strpos($this->attribute, '_like') === false) {
                $this->filter = $this->getDefaultFilter();
            }
        }

        return true;
    }

    protected function getDefaultFilter()
    {
        return ClientCombo::widget([
            'attribute'           => $this->attribute,
            'model'               => $this->grid->filterModel,
            'formElementSelector' => 'td',
            'clientType'          => $this->clientType,
        ]);
    }
}
