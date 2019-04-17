<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets\verification;

/**
 * Interface ForceVerificationWidgetInterface represents widget
 * that provides UI for attribute verification.
 */
interface ForceVerificationWidgetInterface
{
    /**
     * Method returns label for the attribute.
     * @return string
     */
    public function getLabel();

    /**
     * Method returns rendered UI for the attribute verification.
     * @return string
     */
    public function getWidget();

    /**
     * @return bool whether current attribute can be rendered
     */
    public function canBeRendered();
}
