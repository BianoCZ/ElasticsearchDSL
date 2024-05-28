<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\GeoBoundsAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for geo bounds aggregation.
 */
class GeoBoundsAggregationTest extends TestCase
{

    /**
     * Test if exception is thrown.
     */
    public function testGeoBoundsAggregationException(): void
    {
        $this->expectException(LogicException::class);
        $agg = new GeoBoundsAggregation('test_agg');
        $agg->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testGeoBoundsAggregationGetType(): void
    {
        $agg = new GeoBoundsAggregation('foo');
        $result = $agg->getType();
        $this->assertEquals('geo_bounds', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testGeoBoundsAggregationGetArray(): void
    {
        $agg = new GeoBoundsAggregation('foo');
        $agg->setField('bar');
        $agg->setWrapLongitude(true);
        $result = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => true,
            ],
        ];
        $this->assertEquals($result, $agg->toArray(), 'when wraplongitude is true');

        $agg->setWrapLongitude(false);
        $result = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => false,
            ],
        ];
        $this->assertEquals($result, $agg->toArray(), 'when wraplongitude is false');
    }

}
