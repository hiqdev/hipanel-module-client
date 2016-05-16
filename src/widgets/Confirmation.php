<?php

namespace hipanel\modules\client\widgets;

use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\web\JsExpression;

class Confirmation extends Widget
{
    /**
     * @var \hipanel\modules\client\models\Confirmation
     */
    public $model;
    /**
     * @var string
     */
    public $scenario;
    /**
     * @var string
     */
    public $type;

    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('Please specify the "model" property.');
        }

        if ($this->scenario === null) {
            $this->scenario = 'set-confirmation';
        }

        if ($this->type === null) {
            $this->type = $this->model->type;
        }
    }

    public function run()
    {
        $xeditable = $this->renderXEditable();

        if ($this->model->date) {
            return Yii::t('hipanel/client', '{statusXeditable} since {date}', [
             'statusXeditable' => $xeditable,
             'date' => Yii::$app->formatter->asDate($this->model->date)
            ]);
        } else {
            return Yii::t('hipanel/client', '{statusXeditable}', [
                'statusXeditable' => $xeditable
            ]);
        }
    }

    protected function renderXEditable()
    {
        return\hipanel\widgets\XEditable::widget([
            'model' => $this->model,
            'attribute' => 'level',
            'scenario' => $this->scenario,
            'pluginOptions' => [
                'type' => 'select',
                'source' => $this->model->getAvailableLevels(),
                'params' => new JsExpression("function (params) {
                    params.type = '$this->type';
                    return params;
                }"),
                'display' => new JsExpression("function (value, sourceData) {
                    var elem = $.grep(sourceData, function (o) { return o.value == value; });
                    var classes = {
                        unconfirmed: 'text-warning',
                        confirmed: '',
                        fullverified: 'text-success',
                    };

                    $.map(classes, function(val) {
                        return $(this).removeClass(val);
                    }.bind(this));

                    if (value instanceof String) {
                        var newClass = classes[value[0]];
                    } else {
                        newClass = classes[value];
                    }

                    $(this).text(elem[0].text).addClass(newClass);
                }"),
            ],
        ]);
    }
}
