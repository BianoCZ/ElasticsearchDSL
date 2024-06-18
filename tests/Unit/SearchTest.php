<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit;

use Biano\ElasticsearchDSL\Search;
use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{

    public function testItCanBeInstantiated(): void
    {
        self::assertInstanceOf(Search::class, new Search());
    }

    public function testScrollUriParameter(): void
    {
        $search = new Search();
        $search->setScroll('5m');

        self::assertArrayHasKey('scroll', $search->getUriParams());
    }

}
