<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class DateHistogramAggregationTest extends TestCase
{

    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayExceptionWhenDontSendInterval(): void
    {
        $this->expectException(LogicException::class);
        $aggregation = new DateHistogramAggregation('foo', 'date');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testDateHistogramAggregationGetType(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('date_histogram', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testChildrenAggregationGetArray(): void
    {
        $mock = $this->getMockBuilder(AbstractAggregation::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->setName('name');
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->addAggregation($mock);
        $aggregation->setField('date');
        $aggregation->setCalendarInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'calendar_interval' => 'month'];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method.
     */
    public function testCalendarIntervalGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->setField('date');
        $aggregation->setCalendarInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'calendar_interval' => 'month'];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method.
     */
    public function testFixedIntervalGetArray(): void
    {
        $aggregation = new DateHistogramAggregation('foo');
        $aggregation->setField('date');
        $aggregation->setFixedInterval('month');
        $result = $aggregation->getArray();
        $expected = ['field' => 'date', 'fixed_interval' => 'month'];
        $this->assertEquals($expected, $result);
    }

}
