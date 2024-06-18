<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\CumulativeSumAggregation;
use PHPUnit\Framework\TestCase;

class CumulativeSumAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new CumulativeSumAggregation('acme', 'test');

        $expected = [
            'cumulative_sum' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
