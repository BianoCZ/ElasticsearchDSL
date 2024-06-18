<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\ExtendedStatsBucketAggregation;
use PHPUnit\Framework\TestCase;

class ExtendedStatsBucketAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new ExtendedStatsBucketAggregation('acme', 'test');

        $expected = [
            'extended_stats_bucket' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
