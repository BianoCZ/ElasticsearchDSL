<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\MovingFunctionAggregation;
use PHPUnit\Framework\TestCase;

class MovingFunctionAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new MovingFunctionAggregation('acme', 'test');

        $expected = [
            'moving_fn' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
