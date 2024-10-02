<?php declare(strict_types=1);
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\modules\client\widgets\combo\ClientCombo;
use hiqdev\hiart\ActiveRecord;
use hiqdev\higrid\DataColumn;
use Yii;
use yii\helpers\Html;
use yii\web\User;

/**
 *
 * @property-read mixed $defaultFilter
 */
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
        $user = Yii::$app->user;
        $this->visible = $user->can('access-subclients');
        if (!$this->visible) {
            return null;
        }

        if (!$this->sortAttribute) {
            $this->sortAttribute = $this->nameAttribute;
        }
        if ($this->value === null) {
            $this->value = fn(ActiveRecord $model): string => $this->getValue($model, $user);
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

    public function getValue(ActiveRecord $model, User $user): string
    {
        if (!isset($model->{$this->nameAttribute})) {
            return '';
        }
        $isStaff = $user->can('owner-staff');
        $isManager = ($user->can('access-reseller') && $model->{$this->idAttribute} && $user->identity->hasOwnSeller($model->{$this->idAttribute}));
        $isSeller = (!empty($model->seller_id) && ($model->seller_id === $user->id || $model->seller_id === $user->identity->seller_id));
        if ($isStaff || $isManager || $isSeller) {
            return Html::a($model->{$this->nameAttribute}, ['@client/view', 'id' => $model->{$this->idAttribute}]);
        }

        return $model->{$this->nameAttribute};
    }

    protected function getDefaultFilter()
    {
        return ClientCombo::widget([
            'attribute' => $this->attribute,
            'model' => $this->grid->filterModel,
            'formElementSelector' => 'td',
            'clientType' => $this->clientType,
        ]);
    }
}
