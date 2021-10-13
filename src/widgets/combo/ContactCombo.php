<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\combo;

use hipanel\helpers\ArrayHelper;
use hiqdev\combo\Combo;
use yii\web\JsExpression;

/**
 * Class ContactCombo.
 */
class ContactCombo extends Combo
{
    /** {@inheritdoc} */
    public $type = 'client/contact';

    /** {@inheritdoc} */
    public $name = 'name';

    /** {@inheritdoc} */
    public $url = '/client/contact/search';

    /** {@inheritdoc} */
    public $_return = ['id', 'name', 'email'];

    /** {@inheritdoc} */
    public function getPluginOptions($options = [])
    {
        return parent::getPluginOptions([
            'select2Options' => [
                'templateResult' => new JsExpression("function (data) {
                    if (data.loading) {
                        return data.text;
                    }

                    return data.name + '<br>' + data.email;
                }"),
                'escapeMarkup' => new JsExpression('function (markup) {
                    return markup; // Allows HTML
                }'),
            ],
            'clearWhen' => ['client/client'],
        ]);
    }

    /** {@inheritdoc} */
    public function getFilter()
    {
        return ArrayHelper::merge(parent::getFilter(), [
            'client' => 'client/client',
            'select' => ['format' => 'min'],
        ]);
    }
}
