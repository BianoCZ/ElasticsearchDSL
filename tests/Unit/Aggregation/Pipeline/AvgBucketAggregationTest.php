<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\AvgBucketAggregation;
use PHPUnit\Framework\TestCase;

class AvgBucketAggregationTest extends TestCase
{

    public function testGetArray(): void
    {
        $aggregation = new AvgBucketAggregation('foo', 'foo>bar');

        self::assertEquals(['buckets_path' => 'foo>bar'], $aggregation->getArray());
    }

    public function testAvgBucketAggregationGetType(): void
    {
        $aggregation = new AvgBucketAggregation('foo', 'foo>bar');

        self::assertEquals('avg_bucket', $aggregation->getType());
    }

}
