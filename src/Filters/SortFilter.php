<?php

declare(strict_types=1);

namespace Kazakevic\StrapiWrapper\Filters;

use Kazakevic\StrapiWrapper\Constants\SortOrder;

class SortFilter
{
    private string $sortByFieldName;
    private SortOrder $sortOrder;

    public function __construct(string $sortByFieldName, SortOrder $sortOrder = SortOrder::ASC)
    {
        $this->sortByFieldName = $sortByFieldName;
        $this->sortOrder = $sortOrder;
    }

    public function getSortByFieldName(): string
    {
        return $this->sortByFieldName;
    }

    public function getSortOrder(): SortOrder
    {
        return $this->sortOrder;
    }
}
