<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\TopHitsAggregation;
use Biano\ElasticsearchDSL\Sort\FieldSort;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for top hits aggregation.
 */
class TopHitsAggregationTest extends TestCase
{

    /**
     * Check if aggregation returns the expected array.
     */
    public function testToArray(): void
    {
        $sort = new FieldSort('acme', FieldSort::ASC);
        $aggregation = new TopHitsAggregation('acme', 1, 1, $sort);

        $expected = [
            'top_hits' => [
                'sort' => [
                    ['acme' => ['order' => 'asc']],
                ],
                'size' => 1,
                'from' => 1,
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

    /**
     * Check if parameters can be set to agg.
     */
    public function testParametersAddition(): void
    {
        $aggregation = new TopHitsAggregation('acme', 0, 1);
        $aggregation->addParameter('_source', ['include' => ['title']]);

        $expected = [
            'top_hits' => [
                'size' => 0,
                'from' => 1,
                '_source' => [
                    'include' => ['title'],
                ],
            ],
        ];

        $this->assertSame($expected, $aggregation->toArray());
    }

}
