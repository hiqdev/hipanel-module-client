<?php
declare(strict_types=1);

namespace hipanel\modules\client\models;

use hipanel\base\Model;
use hipanel\base\ModelTrait;
use hipanel\modules\client\widgets\BankDetailsSummaryRenderWidget;
use Yii;
use yii\web\JsExpression;

/**
 * @property string $summary renamed from old attribute `bank_details`
 */
class BankDetails extends Model
{
    use ModelTrait;

    public function formName()
    {
        return implode('', [$this->requisite_id, parent::formName()]);
    }

    public function fillBankDetailsSummary(): void
    {
        $this->summary = BankDetailsSummaryRenderWidget::widget(['models' => [$this]]);
    }

    public function rules()
    {
        return [
            [['id', 'requisite_id', 'no'], 'integer'],
            [
                [
                    'currency',
                    'bank_name',
                    'bank_account',
                    'bank_address',
                    'bank_swift',
                    'bank_correspondent',
                    'bank_correspondent_swift',
                    'summary',
                ],
                'string',
            ],
            [
                [
                    'bank_account',
                    'bank_name',
                    'bank_address',
                    'bank_swift',
                    'bank_correspondent',
                    'bank_correspondent_swift',
                ],
                'trim',
            ],
            [['currency', 'bank_account'], 'required', 'on' => 'force-validate'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'summary' => Yii::t('hipanel:client', 'Bank account'),
            'bank_name' => Yii::t('hipanel:client', 'Bank name'),
            'bank_account' => Yii::t('hipanel:client', 'Bank account'),
            'bank_address' => Yii::t('hipanel:client', 'Bank address'),
            'bank_swift' => Yii::t('hipanel:client', 'SWIFT code'),
            'bank_correspondent' => Yii::t('hipanel:client', 'Correspondent bank'),
            'bank_correspondent_swift' => Yii::t('hipanel:client', 'Correspondent bank SWIFT code'),
        ];
    }

    public function getIsNewRecord()
    {
        if (!empty($this->bank_name) || !empty($this->bank_account)) {
            return false;
        }

        return parent::getIsNewRecord();
    }

    public function hydrateWithData(array $data): self
    {
        $this->load($data, '');
        $this->fillBankDetailsSummary();

        return $this;
    }
}
