<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\MinBucketAggregation;
use PHPUnit\Framework\TestCase;

class MinBucketAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new MinBucketAggregation('acme', 'test');

        $expected = [
            'min_bucket' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
