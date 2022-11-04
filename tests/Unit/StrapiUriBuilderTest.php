<?php

declare(strict_types=1);

namespace StrapiWrapper\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Kazakevic\StrapiWrapper\StrapiUriBuilder;

class StrapiUriBuilderTest extends TestCase
{
    private const BASE_URL = 'https://localhost:port';
    private const ITEM_ID = 'my-collection-item-id';

    public function testForItemsUriWithLimit(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/?pagination[start]=0&pagination[limit]=1000';
        $uri = (new StrapiUriBuilder(static::BASE_URL))
            ->forItems(static::ITEM_ID)
            ->withOffsetAndLimit(1000)
            ->getUri();
        static::assertEquals($expected, $uri);
    }

    public function testForItemUri(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/12/?';
        $uri = (new StrapiUriBuilder(static::BASE_URL))
            ->forItem(static::ITEM_ID, 12)
            ->getUri();
        static::assertEquals($expected, $uri);
    }

    public function testForItemsWithMedia(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/?populate=%2A';
        $uri = (new StrapiUriBuilder(static::BASE_URL))
            ->forItems(static::ITEM_ID)
            ->withMedia()
            ->getUri();

        static::assertEquals($expected, $uri);
    }

    public function testForItemsWithPaginationUri(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/?pagination[start]=0&pagination[limit]=100';
        $uri = (new StrapiUriBuilder(static::BASE_URL))
            ->forItems(static::ITEM_ID)
            ->withOffsetAndLimit(100)
            ->getUri();

        static::assertEquals($expected, $uri);
    }

    public function testForItemsWithMediaWithPaginationUri(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/?populate=%2A&pagination[start]=0&pagination[limit]=100';
        $uri = (new StrapiUriBuilder(static::BASE_URL))
            ->forItems(static::ITEM_ID)
            ->withMedia()
            ->withOffsetAndLimit(100)
            ->getUri();

        static::assertEquals($expected, $uri);
    }

    public function testForItemsWithFilter(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/?populate=%2A&filters[slug][$eq]=secret-slug&pagination[start]=0&pagination[limit]=100';
        $uri = (new StrapiUriBuilder(static::BASE_URL))
            ->forItems(static::ITEM_ID)
            ->withMedia()
            ->withFilter('slug', 'secret-slug')
            ->withOffsetAndLimit(100)
            ->getUri();

        static::assertEquals($expected, $uri);
    }
}
