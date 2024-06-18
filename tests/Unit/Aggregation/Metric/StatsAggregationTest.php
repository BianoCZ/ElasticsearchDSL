<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\StatsAggregation;
use PHPUnit\Framework\TestCase;

class StatsAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new StatsAggregation('test_agg');
        $aggregation->setField('test_field');

        $expected = [
            'stats' => ['field' => 'test_field'],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

    public function testConstructor(): void
    {
        $aggregation = new StatsAggregation('foo', 'fieldValue', 'scriptValue');

        self::assertSame(
            [
                'stats' => [
                    'field' => 'fieldValue',
                    'script' => 'scriptValue',
                ],
            ],
            $aggregation->toArray(),
        );
    }

}
