<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\widgets;

use hipanel\base\Model;
use hipanel\modules\client\models\Client;
use hipanel\modules\client\models\Contact;
use hipanel\modules\client\widgets\verification\ForceVerificationWidgetInterface;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class ForceVerificationBlock extends Widget
{
    const EVENT_COLLECT_WIDGETS = 'collectWidgets';

    /**
     * @var Model|Client
     */
    public $client;
    /**
     * @var Contact
     */
    public $contact;
    /**
     * @var string
     */
    public $scenario;
    /**
     * @var array of widgets that should be rendered
     */
    public $widgets;
    /**
     * @var string the title of verification block
     */
    public $title;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if ($this->contact === null && $this->client === null) {
            throw new InvalidConfigException('Property "contact" or "client" must be specified.');
        }

        if ($this->title === null) {
            $this->title = Yii::t('hipanel:client', 'Verification status');
        }

        $this->collectWidgets();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!Yii::$app->user->can('contact.force-verify')) {
            return null;
        }

        if (Yii::$app->user->id === (int) $this->contact->client_id) {
            return null;
        }

        return $this->render((new \ReflectionClass($this))->getShortName(), [
            'widgets' => $this->widgets,
            'title' => $this->title,
        ]);
    }

    /**
     * @param string $name
     * @param ForceVerificationWidgetInterface $widget
     * @throws InvalidConfigException
     */
    public function registerWidget($name, $widget)
    {
        if (!$widget instanceof ForceVerificationWidgetInterface) {
            throw new InvalidConfigException('Widget must implement "ForceVerificationWidgetInterface"');
        }

        $this->widgets[$name] = $widget;
    }

    /**
     * Triggers event that collect required widgets.
     */
    protected function collectWidgets()
    {
        $this->trigger(self::EVENT_COLLECT_WIDGETS);
    }
}
