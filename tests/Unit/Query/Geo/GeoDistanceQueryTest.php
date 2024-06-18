<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Geo;

use Biano\ElasticsearchDSL\Query\Geo\GeoDistanceQuery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeoDistanceQueryTest extends TestCase
{

    /**
     * @param array<mixed> $location
     * @param array<string,mixed> $parameters
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(string $field, string $distance, array $location, array $parameters, array $expected): void
    {
        $query = new GeoDistanceQuery($field, $distance, $location, $parameters);

        $result = $query->toArray();

        self::assertEquals(['geo_distance' => $expected], $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        // Case #1.
        yield [
            'field' => 'location',
            'distance' => '200km',
            'location' => ['lat' => 40, 'lon' => -70],
            'parameters' => [],
            'expected' => ['distance' => '200km', 'location' => ['lat' => 40, 'lon' => -70]],
        ];

        // Case #2.
        yield [
            'field' => 'location',
            'distance' => '20km',
            'location' => ['lat' => 0, 'lon' => 0],
            'parameters' => ['parameter' => 'value'],
            'expected' => ['distance' => '20km', 'location' => ['lat' => 0, 'lon' => 0], 'parameter' => 'value'],
        ];
    }

}
