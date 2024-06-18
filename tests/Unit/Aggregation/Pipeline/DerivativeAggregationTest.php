<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\DerivativeAggregation;
use PHPUnit\Framework\TestCase;

class DerivativeAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new DerivativeAggregation('foo', 'foo>bar');
        $aggregation->addParameter('gap_policy', 'skip');

        $expected = [
            'derivative' => [
                'buckets_path' => 'foo>bar',
                'gap_policy' => 'skip',
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
