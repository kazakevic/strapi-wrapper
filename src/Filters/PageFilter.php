<?php

declare(strict_types=1);

namespace Kazakevic\StrapiWrapper\Filters;

class PageFilter
{
    private int $limit;
    private int $offset;

    public function __construct(int $limit, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
