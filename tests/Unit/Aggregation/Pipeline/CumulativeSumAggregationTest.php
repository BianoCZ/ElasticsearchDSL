<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\CumulativeSumAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for cumulative sum aggregation.
 */
class CumulativeSumAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $aggregation = new CumulativeSumAggregation('acme', 'test');

        $expected = [
            'cumulative_sum' => ['buckets_path' => 'test'],
        ];

        $this->assertEquals($expected, $aggregation->toArray());
    }

}
