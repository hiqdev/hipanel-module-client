<?php declare(strict_types=1);

namespace hipanel\modules\client\helpers\blacklist;

interface BlacklistCategoryInterface
{
    public function getValue(): string;
    public function getLabel(): string;
    public function getUrlAlias(): string;
    public function getRefsName(): string;
}
