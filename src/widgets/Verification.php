<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\web\JsExpression;

class Verification extends Widget
{
    /**
     * @var \hipanel\modules\client\models\Verification
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
    /**
     * @var string
     */
    public $submitUrl;
    /**
     * @var string
     */
    public $title;

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

        if ($this->submitUrl === null) {
            $this->submitUrl = '@contact/set-confirmation';
        }

        if ($this->title === null) {
            $this->title = Yii::t('hipanel:client', 'Verification level');

        }

    }

    public function run()
    {
        $xeditable = $this->renderXEditable();

        if ($this->model->date) {
            return Yii::t('hipanel:client', '{statusXeditable} since {date}', [
             'statusXeditable' => $xeditable,
             'date' => Yii::$app->formatter->asDate($this->model->date),
            ]);
        } else {
            return Yii::t('hipanel:client', '{statusXeditable}', [
                'statusXeditable' => $xeditable,
            ]);
        }
    }

    protected function renderXEditable()
    {
        return \hipanel\widgets\XEditable::widget([
            'model' => $this->model,
            'attribute' => 'level',
            'scenario' => $this->scenario,
            'linkOptions' => [
                'id' => $this->getId(),
                'data-attribute' => $this->type
            ],
            'pluginOptions' => [
                'url' => $this->submitUrl,
                'selector' => '#' . $this->getId(),
                'type' => 'select',
                'title' => $this->title,
                'source' => $this->model->getAvailableLevels(),
                'params' => new JsExpression("function (params) {
                    params.type = $(this).attr('data-attribute');
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
