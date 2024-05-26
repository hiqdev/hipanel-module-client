<?php declare(strict_types=1);

namespace hipanel\modules\client\helpers\blacklist;

class WhitelistCategory implements BlacklistCategoryInterface
{
    /**
     * The original name of category on API side
     * @return string
     */
    public function getValue(): string
    {
        return 'whitelisted';
    }

    public function getLabel(): string
    {
        return 'Whitelist';
    }

    public function getUrlAlias(): string
    {
        return '@whitelist';
    }

    public function getRefsName(): string
    {
        return 'type,' . $this->getValue();
    }
}
