<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\PercentilesBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for percentiles bucket aggregation.
 */
class PercentilesBucketAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new PercentilesBucketAggregation('acme', 'test');
        $aggregation->setPercents([25.0, 50.0, 75.0]);

        $expected = [
            'percentiles_bucket' => [
                'buckets_path' => 'test',
                'percents' => [25.0, 50.0, 75.0],
            ],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

}
