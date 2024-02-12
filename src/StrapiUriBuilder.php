<?php

declare(strict_types=1);

namespace Kazakevic\StrapiWrapper;

use Kazakevic\StrapiWrapper\Constants\FilterOperator;
use Kazakevic\StrapiWrapper\Constants\SortOrder;
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

    public function forItemSingle(string $itemIdentifier): self
    {
        $this->uri = $this->baseUrl . '/api/' . $itemIdentifier . '/';
        return $this;
    }

    public function withMedia(): self
    {
        $this->prependUri();
        $this->uri .= StrapiFilter::POPULATE->value . '=%2A';

        return $this;
    }

    public function withOffsetAndLimit(int $limit, int $offset = 0): self
    {
        $this->prependUri();

        $filterUri = sprintf(StrapiFilter::PAGINATION->value, FilterOperator::START->value) . '=' . $offset . '&';
        $filterUri .= sprintf(StrapiFilter::PAGINATION->value, FilterOperator::LIMIT->value) . '=' . $limit;

        $this->uri .= $filterUri;

        return $this;
    }

    public function withFilter(string $fieldName, string $fieldValue): self
    {
        $this->prependUri();
        $uri = sprintf(StrapiFilter::FILTERS->value, $fieldName, FilterOperator::EQ->value) . '=' . $fieldValue;

        $this->uri .= $uri;

        return $this;
    }

    public function sortBy(string $fieldName, SortOrder $sortOrder): self
    {
        $this->prependUri();
        $this->uri .= StrapiFilter::SORT->value . '=' . $fieldName . ':' . $sortOrder->value;

        return $this;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    private function prependUri(): void
    {
        if (!str_ends_with($this->uri, '?') && !str_ends_with($this->uri, '&')) {
            $this->uri .= '&';
        }
    }
}
