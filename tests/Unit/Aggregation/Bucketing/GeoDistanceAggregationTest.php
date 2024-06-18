<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\GeoDistanceAggregation;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeoDistanceAggregationTest extends TestCase
{

    public function testGeoDistanceAggregationExceptionWhenFieldIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Geo distance aggregation must have a field set.');

        $aggregation = new GeoDistanceAggregation('test_agg');
        $aggregation->setOrigin('50, 70');
        $aggregation->getArray();
    }

    public function testGeoDistanceAggregationExceptionWhenOriginIsNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Geo distance aggregation must have an origin set.');

        $aggregation = new GeoDistanceAggregation('test_agg');
        $aggregation->setField('location');
        $aggregation->getArray();
    }

    public function testGeoDistanceAggregationAddRangeException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Either from or to must be set. Both cannot be null.');

        $aggregation = new GeoDistanceAggregation('test_agg');
        $aggregation->addRange();
    }

    /**
     * @param array<string,mixed> $filterData
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideGeoDistanceAggregationGetArray')]
    public function testGeoDistanceAggregationGetArray(array $filterData, array $expected): void
    {
        $aggregation = new GeoDistanceAggregation('foo');
        $aggregation->setOrigin($filterData['origin']);
        $aggregation->setField($filterData['field']);
        $aggregation->setUnit($filterData['unit']);
        $aggregation->setDistanceType($filterData['distance_type']);
        $aggregation->addRange($filterData['ranges'][0], $filterData['ranges'][1]);

        $result = $aggregation->getArray();

        self::assertEquals($expected, $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideGeoDistanceAggregationGetArray(): iterable
    {
        $filterData = [
            'field' => 'location',
            'origin' => '52.3760, 4.894',
            'unit' => 'mi',
            'distance_type' => 'plane',
            'ranges' => [100, 300],
        ];

        $expected = [
            'field' => 'location',
            'origin' => '52.3760, 4.894',
            'unit' => 'mi',
            'distance_type' => 'plane',
            'ranges' => [['from' => 100, 'to' => 300]],
        ];

        yield [
            'filterData' => $filterData,
            'expected' => $expected,
        ];
    }

    public function testGeoDistanceAggregationGetType(): void
    {
        $aggregation = new GeoDistanceAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('geo_distance', $result);
    }

    public function testConstructorFilter(): void
    {
        $aggregation = new GeoDistanceAggregation(
            'test',
            'fieldName',
            'originValue',
            [
                ['from' => 'value'],
                ['to' => 'value'],
                ['from' => 'value', 'to' => 'value2'],
            ],
            'unitValue',
            'distanceTypeValue',
        );

        self::assertSame(
            [
                'geo_distance' => [
                    'field' => 'fieldName',
                    'origin' => 'originValue',
                    'unit' => 'unitValue',
                    'distance_type' => 'distanceTypeValue',
                    'ranges' => [
                        ['from' => 'value'],
                        ['to' => 'value'],
                        ['from' => 'value', 'to' => 'value2'],
                    ],
                ],
            ],
            $aggregation->toArray(),
        );
    }

}
