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
        $this->assertInstanceOf(
            AggregationsEndpoint::class,
            new AggregationsEndpoint(),
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $aggName = 'acme_agg';
        $agg = new MissingAggregation('acme');
        $endpoint = new AggregationsEndpoint();
        $endpoint->add($agg, $aggName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($agg, $builders[$aggName]);
    }

}
