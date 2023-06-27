<?php
/**
 * Finance module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-finance
 * @package   hipanel-module-finance
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\grid;

use hipanel\grid\DataColumn;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\widgets\BankDetailsSummaryRenderWidget;
use hipanel\modules\finance\models\Requisite;
use Yii;
use yii\helpers\Html;

class RequisitesColumn extends DataColumn
{
    public $format = 'raw';
    public $attribute = 'requisites';

    public function init()
    {
        parent::init();
        $this->label = Yii::t('hipanel:finance', 'Requisites');
        $this->visible = Yii::$app->user->can('requisites.read');
    }

    public function getDataCellValue($model, $key, $index)
    {
        /** @var Requisite|Contact $model */
        $result = implode("\n",
                array_filter([
                    $model->organization,
                    $model->renderAddress(),
                    $model->vat_number,
                    $model->invoice_last_no,
                ])) . "\n\n";
        $result .= BankDetailsSummaryRenderWidget::widget(['models' => $model->bankDetails]);

        return nl2br(Html::encode($result));
    }
}
