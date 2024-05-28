<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\StatsBucketAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for stats bucket aggregation.
 */
class StatsBucketAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new StatsBucketAggregation('acme', 'test');

        $expected = [
            'stats_bucket' => ['buckets_path' => 'test'],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

}
