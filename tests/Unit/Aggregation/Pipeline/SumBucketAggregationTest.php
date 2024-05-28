<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\SumBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for sum bucket aggregation.
 */
class SumBucketAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new SumBucketAggregation('acme', 'test');

        $expected = [
            'sum_bucket' => ['buckets_path' => 'test'],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

}
