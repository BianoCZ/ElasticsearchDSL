<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\StatsAggregation;
use PHPUnit\Framework\TestCase;

class StatsAggregationTest extends TestCase
{

    /**
     * Test for stats aggregation toArray() method.
     */
    public function testToArray(): void
    {
        $aggregation = new StatsAggregation('test_agg');
        $aggregation->setField('test_field');

        $expectedResult = [
            'stats' => ['field' => 'test_field'],
        ];

        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Tests if parameter can be passed to constructor.
     */
    public function testConstructor(): void
    {
        $aggregation = new StatsAggregation('foo', 'fieldValue', 'scriptValue');
        $this->assertSame(
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
