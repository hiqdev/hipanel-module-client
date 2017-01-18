<?php

namespace hipanel\modules\client\bootstrap;

use hipanel\modules\client\widgets\verification\ClientVerification;
use hipanel\modules\client\widgets\verification\ForceContactAttributeVerification;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use hipanel\modules\client\widgets\ForceVerificationBlock;

class ContactAttributesVerificationBootstrap implements BootstrapInterface
{
    public function bootstrap($application)
    {
        Event::on(ForceVerificationBlock::class, ForceVerificationBlock::EVENT_COLLECT_WIDGETS, function ($event) {
            /** @var ForceVerificationBlock $sender */
            $sender = $event->sender;

            if (!isset($sender->client)) {
                return;
            }

            $sender->registerWidget('client_verification', Yii::createObject([
                'class' => ClientVerification::class,
                'client' => $sender->client,
            ]));
        });

        Event::on(ForceVerificationBlock::class, ForceVerificationBlock::EVENT_COLLECT_WIDGETS, function ($event) {
            /** @var ForceVerificationBlock $sender */
            $sender = $event->sender;

            if (!isset($sender->contact)) {
                return;
            }

            foreach (['name', 'address', 'email', 'voice_phone', 'fax_phone'] as $attribute) {
                $sender->registerWidget($attribute, Yii::createObject([
                    'class' => ForceContactAttributeVerification::class,
                    'contact' => $sender->contact,
                    'attribute' => $attribute,
                ]));
            }
        });
    }
}
