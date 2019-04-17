<?php
/**
 * Client module for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-client
 * @package   hipanel-module-client
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\modules\client\bootstrap;

use hipanel\modules\client\models\Contact;
use Yii;
use yii\base\ActionEvent;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\helpers\Url;

/**
 * Class ForceGdprVerificationBootstrap checks that user has confirmed
 * his agreement with privacy policies. Otherwise – redirects to agreement page page.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
class ForceGdprVerificationBootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application|\yii\web\Application $app the application currently running
     */
    public function bootstrap($app)
    {
        if (!$app instanceof \yii\web\Application) {
            return;
        }

        $app->on(Application::EVENT_BEFORE_ACTION, function (ActionEvent $event) use ($app) {
            if ($app->user->getIsGuest()) {
                return;
            }

            if ($app->request->getIsAjax()) {
                return;
            }

            $action = $event->action->getUniqueId();
            if (
                strpos($action, 'client/') === 0
                || strpos($action, 'monitoring/') === 0
                || strpos($action, 'site/logout') === 0
            ) {
                return;
            }

            $session = $app->session;
            if ($session->get('contact.gdpr.accepted')) {
                return;
            }

            $contact = Contact::findOne(['id' => $app->user->getId()]);
            if ($contact->gdpr_consent && $contact->policy_consent) {
                $app->session->set('contact.gdpr.accepted', true);

                return;
            }

            $app->response->redirect(Url::to(['@contact/update', 'id' => $app->user->getId()]));
            Yii::$app->end();
        });
    }
}
