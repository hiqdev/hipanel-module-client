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
use yii\helpers\Html;
use hipanel\widgets\Box;

class ForceVerificationBlock extends Widget
{
    /**
     * @var \hipanel\base\Model
     */
    public $model;
    /**
     * options
     *
     * @var array
     */
    public $options = [];
    /**
     * @var string
     */
    public $scenario;
    /**
     * @var string
     */
    public $submitUrl;
    /**
     * @var array
     */
    public $attributes;
    /**
     * @var string
     */
    public $title;

    public function init()
    {
        if ($this->model === null) {
            throw new InvalidConfigException('Please specify the "model" property.');
        }

        if ($this->attributes === null) {
            $this->attributes = ['name', 'address', 'email', 'voice_phone', 'fax_phone'];
        }

        if ($this->title === null) {
            $this->title = Yii::t('hipanel:client', 'Verification status');
        }
    }

    public function run()
    {
        if (Yii::$app->user->can('contact.force-verify')) {
            return $this->render((new \ReflectionClass($this))->getShortName(), [
                'attributes' => $this->attributes,
                'model' => $this->model,
                'title' => $this->title,
                'scenario' => $this->scenario,
                'submitUrl' => $this->submitUrl
            ]);
        }
    }

}
