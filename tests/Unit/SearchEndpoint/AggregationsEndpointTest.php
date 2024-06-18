<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;
use Biano\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint;
use PHPUnit\Framework\TestCase;

class AggregationsEndpointTest extends TestCase
{

    public function testItCanBeInstantiated(): void
    {
        self::assertInstanceOf(AggregationsEndpoint::class, new AggregationsEndpoint());
    }

    public function testEndpointGetter(): void
    {
        $aggName = 'acme_agg';
        $aggregation = new MissingAggregation('acme');
        $endpoint = new AggregationsEndpoint();
        $endpoint->add($aggregation, $aggName);
        $builders = $endpoint->getAll();

        self::assertCount(1, $builders);
        self::assertSame($aggregation, $builders[$aggName]);
    }

}
