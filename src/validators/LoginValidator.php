<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\validators;

use Yii;

/**
 * Class LoginValidator is used to validate logins of clients.
 */
class LoginValidator extends \yii\validators\RegularExpressionValidator
{
    /**
     * {@inheritdoc}
     */
    public $pattern = '/^(([a-z][a-z0-9_]{2,31})|([0-9a-z\._+-]+@([0-9a-z][0-9a-z_-]*\.)+[0-9a-z][0-9a-z-]*))$/i';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->message === null) {
            $this->message = Yii::t('hipanel', '{attribute} should be either an email address or login that begins from letter, contain only letters, digits or underscores and be at least 2 symbols length');
        }
    }
}
