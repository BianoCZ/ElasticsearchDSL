<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Geo;

use Biano\ElasticsearchDSL\Query\Geo\GeoShapeQuery;
use PHPUnit\Framework\TestCase;

class GeoShapeQueryTest extends TestCase
{

    /**
     * Tests toArray() method.
     */
    public function testToArray(): void
    {
        $filter = new GeoShapeQuery(['param1' => 'value1']);
        $filter->addShape('location', 'envelope', [[13, 53], [14, 52]], GeoShapeQuery::INTERSECTS);

        $expected = [
            'geo_shape' => [
                'location' => [
                    'shape' => [
                        'type' => 'envelope',
                        'coordinates' => [[13, 53], [14, 52]],
                    ],
                    'relation' => 'intersects',
                ],
                'param1' => 'value1',
            ],
        ];

        $this->assertEquals($expected, $filter->toArray());
    }

    /**
     * Test for toArray() in case of pre-indexed shape.
     */
    public function testToArrayIndexed(): void
    {
        $filter = new GeoShapeQuery(['param1' => 'value1']);
        $filter->addPreIndexedShape('location', 'DEU', 'countries', 'shapes', 'location', GeoShapeQuery::WITHIN);

        $expected = [
            'geo_shape' => [
                'location' => [
                    'indexed_shape' => [
                        'id' => 'DEU',
                        'type' => 'countries',
                        'index' => 'shapes',
                        'path' => 'location',
                    ],
                    'relation' => 'within',
                ],
                'param1' => 'value1',
            ],
        ];

        $this->assertEquals($expected, $filter->toArray());
    }

}
