<?php declare(strict_types=1);

namespace hipanel\modules\client\helpers\blacklist;

interface BlacklistCategoryInterface
{
    /**
     * The original name of category on API side
     * @return string
     */
    public function getExternalValue(): string;
    public function getLabel(): string;
    public function getUrlAlias(): string;
    public function getRefsName(): string;
}
