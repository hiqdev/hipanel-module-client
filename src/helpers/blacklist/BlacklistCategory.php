<?php declare(strict_types=1);

namespace hipanel\modules\client\helpers\blacklist;

class BlacklistCategory implements BlacklistCategoryInterface
{
    public function getValue(): string
    {
        return 'blacklisted';
    }

    public function getLabel(): string
    {
        return 'Blacklist';
    }

    public function getUrlAlias(): string
    {
        return '@blacklist';
    }

    public function getRefsName(): string
    {
        return 'type,' . $this->getValue();
    }
}
