<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\SumBucketAggregation;
use PHPUnit\Framework\TestCase;

class SumBucketAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new SumBucketAggregation('acme', 'test');

        $expected = [
            'sum_bucket' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
