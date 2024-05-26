<?php declare(strict_types=1);

namespace hipanel\modules\client\helpers\blacklist;

class BlacklistCategoryFactory
{
    public static function getInstance(string $name): BlacklistCategoryInterface
    {
        $whitelistGroup = new WhitelistCategory();
        if (str_contains($name, strtolower($whitelistGroup->getLabel()))) {
            return $whitelistGroup;
        }
        return new BlacklistCategory();
    }
}
