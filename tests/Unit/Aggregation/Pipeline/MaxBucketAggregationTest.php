<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\MaxBucketAggregation;
use PHPUnit\Framework\TestCase;

class MaxBucketAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new MaxBucketAggregation('acme', 'test');

        $expected = [
            'max_bucket' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
