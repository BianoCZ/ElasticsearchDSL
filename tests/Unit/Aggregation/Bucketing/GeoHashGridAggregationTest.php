<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\GeoHashGridAggregation;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeoHashGridAggregationTest extends TestCase
{

    public function testGeoHashGridAggregationException(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new GeoHashGridAggregation('test_agg');
        $aggregation->getArray();
    }

    /**
     * @param array<string,mixed> $filterData
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideGeoHashGridAggregationGetArray')]
    public function testGeoHashGridAggregationGetArray(array $filterData, array $expected): void
    {
        $aggregation = new GeoHashGridAggregation('foo');
        $aggregation->setPrecision($filterData['precision']);
        $aggregation->setSize($filterData['size']);
        $aggregation->setShardSize($filterData['shard_size']);
        $aggregation->setField($filterData['field']);

        $result = $aggregation->getArray();

        self::assertEquals($expected, $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideGeoHashGridAggregationGetArray(): iterable
    {
        $filterData = [
            'field' => 'location',
            'precision' => 3,
            'size' => 10,
            'shard_size' => 10,
        ];

        $expected = [
            'field' => 'location',
            'precision' => 3,
            'size' => 10,
            'shard_size' => 10,
        ];

        yield [
            'filterData' => $filterData,
            'expected' => $expected,
        ];
    }

    public function testGeoHashGridAggregationGetType(): void
    {
        $aggregation = new GeoHashGridAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('geohash_grid', $result);
    }

}
