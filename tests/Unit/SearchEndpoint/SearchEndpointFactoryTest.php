<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use Biano\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use Biano\ElasticsearchDSL\SearchEndpoint\SearchEndpointFactory;
use Biano\ElasticsearchDSL\SearchEndpoint\SearchEndpointInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class SearchEndpointFactoryTest extends TestCase
{

    public function testGet(): void
    {
        $this->expectException(RuntimeException::class);

        SearchEndpointFactory::get('foo');
    }

    public function testFactory(): void
    {
        $endpoint = SearchEndpointFactory::get(AggregationsEndpoint::NAME);

        self::assertInstanceOf(SearchEndpointInterface::class, $endpoint);
    }

}
