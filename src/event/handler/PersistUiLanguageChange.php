<?php

namespace hipanel\modules\client\event\handler;

use hipanel\modules\client\models\Client;
use hiqdev\yii2\language\events\LanguageWasChanged;
use yii\web\User;

/**
 * Class PersistUiLanguageChange reflects the language change
 * to the persistent client settings storage.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 */
final class PersistUiLanguageChange
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(LanguageWasChanged $event): void
    {
        if ($this->user->isGuest || $event->changedToTheSameLanguage()) {
            return;
        }

        try {
            Client::perform('set-class-values', [
                'class' => 'client,basic_settings',
                'values' => [
                    'language' => $event->getLanguage(),
                ],
            ]);
        } catch (\Throwable $e) {
            // Not a big deal.
        }
    }
}
