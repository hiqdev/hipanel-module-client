<?php

/*
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\validators;

/**
 * Class LoginValidator is used to validate logins of clients.
 */
class LoginValidator extends \yii\validators\RegularExpressionValidator
{
    /**
     * {@inheritdoc}
     */
    public $pattern = '/^[a-z][a-z0-9_]{2,31}$/';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->message = \Yii::t('hipanel', '{attribute} should begin with a letter, contain only letters, digits or underscores and be at least 2 symbols length');
    }
}
