<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit;

use Biano\ElasticsearchDSL\Search;
use PHPUnit\Framework\TestCase;

/**
 * Test for Search.
 */
class SearchTest extends TestCase
{

    /**
     * Tests Search constructor.
     */
    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(Search::class, new Search());
    }

    public function testScrollUriParameter(): void
    {
        $search = new Search();
        $search->setScroll('5m');

        $this->assertArrayHasKey('scroll', $search->getUriParams());
    }

}
