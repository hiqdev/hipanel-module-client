<?php declare(strict_types=1);

namespace hipanel\modules\client\tests\_support\Helper;

use Codeception\Module;

class UserCreationHelper extends Module
{
    protected array $requiredFields = ['user_creation_disabled'];

    protected array $config = ['user_creation_disabled' => '0'];

    public function canCreateUsers(): bool
    {
        return $this->config['user_creation_disabled'] === '0';
    }

    public function getDisabledMessage(): string
    {
        return 'Client creation is disabled in the vendor\'s asset settings';
    }
}
