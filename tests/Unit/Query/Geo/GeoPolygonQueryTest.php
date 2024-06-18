<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Geo;

use Biano\ElasticsearchDSL\Query\Geo\GeoPolygonQuery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeoPolygonQueryTest extends TestCase
{

    /**
     * @param list<array<mixed>> $points
     * @param array<string,mixed> $parameters
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(string $field, array $points, array $parameters, array $expected): void
    {
        $filter = new GeoPolygonQuery($field, $points, $parameters);

        $result = $filter->toArray();

        self::assertEquals(['geo_polygon' => $expected], $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        // Case #1.
        yield [
            'field' => 'location',
            'points' => [
                ['lat' => 20, 'lon' => -80],
                ['lat' => 30, 'lon' => -40],
                ['lat' => 70, 'lon' => -90],
            ],
            'parameters' => [],
            'expected' => [
                'location' => [
                    'points' => [
                        ['lat' => 20, 'lon' => -80],
                        ['lat' => 30, 'lon' => -40],
                        ['lat' => 70, 'lon' => -90],
                    ],
                ],
            ],
        ];

        // Case #2.
        yield [
            'field' => 'location',
            'points' => [],
            'parameters' => ['parameter' => 'value'],
            'expected' => [
                'location' => ['points' => []],
                'parameter' => 'value',
            ],
        ];

        // Case #3.
        yield [
            'field' => 'location',
            'points' => [
                ['lat' => 20, 'lon' => -80],
            ],
            'parameters' => ['parameter' => 'value'],
            'expected' => [
                'location' => [
                    'points' => [['lat' => 20, 'lon' => -80]],
                ],
                'parameter' => 'value',
            ],
        ];
    }

}
