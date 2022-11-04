<?php

declare(strict_types=1);

namespace StrapiWrapper\Tests\Unit;

use Kazakevic\StrapiWrapper\StrapiUriBuilder;
use PHPUnit\Framework\TestCase;

class StrapiUriBuilderTest extends TestCase
{
    private const BASE_URL = 'https://localhost:port';
    private const ITEM_ID = 'my-collection-item-id';

    public function testForItemsUri(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/?';
        $uri = (new StrapiUriBuilder(static::BASE_URL))->forItems(static::ITEM_ID)->getUri();
        static::assertEquals($expected, $uri);
    }

    public function testForItemUri(): void
    {
        $expected = 'https://localhost:port/api/my-collection-item-id/12/?';
        $uri = (new StrapiUriBuilder(static::BASE_URL))->forItem(static::ITEM_ID, 12)->getUri();
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
}
