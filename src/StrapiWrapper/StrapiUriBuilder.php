<?php

declare(strict_types=1);

namespace Kazakevic\StrapiWrapper;

use Kazakevic\StrapiWrapper\Constants\FilterOperator;
use Kazakevic\StrapiWrapper\Constants\StrapiFilter;

class StrapiUriBuilder
{
    private string $baseUrl;
    private string $uri;

    public function __construct(string $baseUrl)
    {
        if (str_ends_with($baseUrl, '/')) {
            $baseUrl = rtrim($baseUrl, '/');
        }

        $this->baseUrl = $baseUrl;
    }

    public function forItem(string $itemIdentifier, int $itemId): self
    {
        $this->uri = $this->baseUrl . '/api/' . $itemIdentifier . '/' . $itemId . '/?';
        return $this;
    }

    public function forItems(string $itemIdentifier): self
    {
        $this->uri = $this->baseUrl . '/api/' . $itemIdentifier . '/?';
        return $this;
    }

    public function withMedia(): self
    {
        $this->uri .= StrapiFilter::POPULATE->value . '=%2A';

        return $this;
    }

    public function withOffsetAndLimit(int $limit, int $offset = 0): self
    {
        $params = [
            sprintf(StrapiFilter::PAGINATION->value, FilterOperator::START->value) => $offset,
            sprintf(StrapiFilter::PAGINATION->value, FilterOperator::LIMIT->value) => $limit,
        ];

        $this->uri .= http_build_query($params);

        return $this;
    }

    public function getUri(): string
    {
        return $this->uri;
    }
}
