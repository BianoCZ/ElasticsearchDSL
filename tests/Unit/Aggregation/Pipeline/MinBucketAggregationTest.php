<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\MinBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for min bucket aggregation.
 */
class MinBucketAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new MinBucketAggregation('acme', 'test');

        $expected = [
            'min_bucket' => ['buckets_path' => 'test'],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

}
