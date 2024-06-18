<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\Ipv4RangeAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class Ipv4RangeAggregationTest extends TestCase
{

    public function testIfExceptionIsThrownWhenFieldAndRangeAreNotSet(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new Ipv4RangeAggregation('foo');
        $aggregation->toArray();
    }

    public function testConstructorFilter(): void
    {
        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', [['from' => 'fromValue']]);

        self::assertSame(
            [
                'ip_range' => [
                    'field' => 'fieldName',
                    'ranges' => [['from' => 'fromValue']],
                ],
            ],
            $aggregation->toArray(),
        );

        $aggregation = new Ipv4RangeAggregation('test', 'fieldName', ['maskValue']);

        self::assertSame(
            [
                'ip_range' => [
                    'field' => 'fieldName',
                    'ranges' => [['mask' => 'maskValue']],
                ],
            ],
            $aggregation->toArray(),
        );
    }

}
