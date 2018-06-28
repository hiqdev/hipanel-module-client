<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2018, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\verification;

use hipanel\modules\client\models\Contact;
use hipanel\modules\client\widgets\Verification;
use yii\base\Widget;

/**
 * Class ForceContactAttributeVerification represents verification of a particular
 * contact attribute.
 */
class ForceContactAttributeVerification extends Widget implements ForceVerificationWidgetInterface
{
    /**
     * @var Contact the contact mode
     */
    public $contact;

    /**
     * @var string the validated attribute
     */
    public $attribute;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->contact->getAttributeLabel($this->attribute);
    }

    /**
     * @return string
     */
    public function getWidget()
    {
        return Verification::widget([
            'model' => $this->contact->getVerification($this->attribute),
            'submitUrl' => '@contact/set-confirmation',
        ]);
    }

    /**
     * @return bool
     */
    public function canBeRendered()
    {
        return $this->contact->getAttribute($this->attribute) !== null;
    }
}
