<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\StatsBucketAggregation;
use PHPUnit\Framework\TestCase;

class StatsBucketAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new StatsBucketAggregation('acme', 'test');

        $expected = [
            'stats_bucket' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
