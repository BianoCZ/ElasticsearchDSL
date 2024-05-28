<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use Biano\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use Biano\ElasticsearchDSL\SearchEndpoint\SearchEndpointFactory;
use Biano\ElasticsearchDSL\SearchEndpoint\SearchEndpointInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Unit test class for search endpoint factory.
 */
class SearchEndpointFactoryTest extends TestCase
{

    /**
     * Tests get method exception.
     */
    public function testGet(): void
    {
        $this->expectException(RuntimeException::class);
        SearchEndpointFactory::get('foo');
    }

    /**
     * Tests if factory can create endpoint.
     */
    public function testFactory(): void
    {
        $endpoinnt = SearchEndpointFactory::get(AggregationsEndpoint::NAME);

        $this->assertInstanceOf(SearchEndpointInterface::class, $endpoinnt);
    }

}
