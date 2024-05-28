<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\GeoCentroidAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class GeoCentroidAggregationTest extends TestCase
{

    /**
     * Test if exception is thrown when field is not provided
     */
    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $aggregation = new GeoCentroidAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testGeoCentroidAggregationGetType(): void
    {
        $aggregation = new GeoCentroidAggregation('foo');
        $this->assertEquals('geo_centroid', $aggregation->getType());
    }

    /**
     * Tests getArray method.
     */
    public function testGeoCentroidAggregationGetArray(): void
    {
        $aggregation = new GeoCentroidAggregation('foo', 'location');
        $this->assertEquals(['field' => 'location'], $aggregation->getArray());
    }

}
