<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\GeoCentroidAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class GeoCentroidAggregationTest extends TestCase
{

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new GeoCentroidAggregation('foo');
        $aggregation->getArray();
    }

    public function testGeoCentroidAggregationGetType(): void
    {
        $aggregation = new GeoCentroidAggregation('foo');

        self::assertEquals('geo_centroid', $aggregation->getType());
    }

    public function testGeoCentroidAggregationGetArray(): void
    {
        $aggregation = new GeoCentroidAggregation('foo', 'location');

        self::assertEquals(['field' => 'location'], $aggregation->getArray());
    }

}
