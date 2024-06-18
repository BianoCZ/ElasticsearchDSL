<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Geo;

use Biano\ElasticsearchDSL\Query\Geo\GeoBoundingBoxQuery;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeoBoundingBoxQueryTest extends TestCase
{

    public function testGeoBoundBoxQueryException(): void
    {
        $this->expectException(LogicException::class);

        $query = new GeoBoundingBoxQuery('location', []);
        $query->toArray();
    }

    /**
     * @param array<mixed> $values
     * @param array<string,mixed> $parameters
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(string $field, array $values, array $parameters, array $expected): void
    {
        $query = new GeoBoundingBoxQuery($field, $values, $parameters);

        $result = $query->toArray();

        self::assertEquals(['geo_bounding_box' => $expected], $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        // Case #1 (2 values).
        yield [
            'field' => 'location',
            'values' => [
                ['lat' => 40.73, 'lon' => -74.1],
                ['lat' => 40.01, 'lon' => -71.12],
            ],
            'parameters' => ['parameter' => 'value'],
            'expected' => [
                'location' => [
                    'top_left' => ['lat' => 40.73, 'lon' => -74.1],
                    'bottom_right' => ['lat' => 40.01, 'lon' => -71.12],
                ],
                'parameter' => 'value',
            ],
        ];

        // Case #2 (2 values with keys).
        yield [
            'field' => 'location',
            'values' => [
                'bottom_right' => ['lat' => 40.01, 'lon' => -71.12],
                'top_left' => ['lat' => 40.73, 'lon' => -74.1],
            ],
            'parameters' => ['parameter' => 'value'],
            'expected' => [
                'location' => [
                    'top_left' => ['lat' => 40.73, 'lon' => -74.1],
                    'bottom_right' => ['lat' => 40.01, 'lon' => -71.12],
                ],
                'parameter' => 'value',
            ],
        ];

        // Case #2 (4 values).
        yield [
            'field' => 'location',
            'values' => [40.73, -74.1, 40.01, -71.12],
            'parameters' => ['parameter' => 'value'],
            'expected' => [
                'location' => [
                    'top' => 40.73,
                    'left' => -74.1,
                    'bottom' => 40.01,
                    'right' => -71.12,
                ],
                'parameter' => 'value',
            ],
        ];

        // Case #3 (4 values with keys).
        yield [
            'field' => 'location',
            'values' => [
                // out of order
                'right' => -71.12,
                'bottom' => 40.01,
                'top' => 40.73,
                'left' => -74.1,
            ],
            'parameters' => ['parameter' => 'value'],
            'expected' => [
                'location' => [
                    'top' => 40.73,
                    'left' => -74.1,
                    'bottom' => 40.01,
                    'right' => -71.12,
                ],
                'parameter' => 'value',
            ],
        ];
    }

}
