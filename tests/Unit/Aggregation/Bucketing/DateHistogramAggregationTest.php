<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class DateHistogramAggregationTest extends TestCase
{

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->getArray();
    }

    public function testGetArrayExceptionWhenDontSendInterval(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new DateHistogramAggregation('foo', 'date');
        $aggregation->getArray();
    }

    public function testDateHistogramAggregationGetType(): void
    {
        $aggregation = new DateHistogramAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('date_histogram', $result);
    }

    public function testChildrenAggregationGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->addAggregation(new AggregationMock('name'));
        $aggregation->setField('date');
        $aggregation->setCalendarInterval('month');

        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'calendar_interval' => 'month'];

        self::assertEquals($expected, $result);
    }

    public function testCalendarIntervalGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->setField('date');
        $aggregation->setCalendarInterval('month');

        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'calendar_interval' => 'month'];

        self::assertEquals($expected, $result);
    }

    public function testFixedIntervalGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->setField('date');
        $aggregation->setFixedInterval('month');

        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'fixed_interval' => 'month'];

        self::assertEquals($expected, $result);
    }

}
