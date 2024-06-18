<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\GeoBoundsAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class GeoBoundsAggregationTest extends TestCase
{

    public function testGeoBoundsAggregationException(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new GeoBoundsAggregation('test_agg');
        $aggregation->getArray();
    }

    public function testGeoBoundsAggregationGetType(): void
    {
        $aggregation = new GeoBoundsAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('geo_bounds', $result);
    }

    public function testGeoBoundsAggregationGetArray(): void
    {
        $aggregation = new GeoBoundsAggregation('foo');
        $aggregation->setField('bar');
        $aggregation->setWrapLongitude(true);

        $result = $aggregation->toArray();
        $expected = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => true,
            ],
        ];

        self::assertEquals($expected, $result);

        $aggregation->setWrapLongitude(false);

        $result = $aggregation->toArray();
        $expected = [
            'geo_bounds' => [
                'field' => 'bar',
                'wrap_longitude' => false,
            ],
        ];

        self::assertEquals($expected, $result);
    }

}
