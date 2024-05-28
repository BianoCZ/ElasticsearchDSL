<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\MaxBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for max bucket aggregation.
 */
class MaxBucketAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new MaxBucketAggregation('acme', 'test');

        $expected = [
            'max_bucket' => ['buckets_path' => 'test'],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

}
