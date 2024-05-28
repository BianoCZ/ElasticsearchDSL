<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\AvgBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for avg_bucket aggregation.
 */
class AvgBucketAggregationTest extends TestCase
{

    /**
     * Tests getArray method.
     */
    public function testGetArray(): void
    {
        $aggregation = new AvgBucketAggregation('foo', 'foo>bar');

        $this->assertEquals(['buckets_path' => 'foo>bar'], $aggregation->getArray());
    }

    /**
     * Tests getType method.
     */
    public function testAvgBucketAggregationGetType(): void
    {
        $aggregation = new AvgBucketAggregation('foo', 'foo>bar');
        $this->assertEquals('avg_bucket', $aggregation->getType());
    }

}
