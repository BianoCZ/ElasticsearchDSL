<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\HistogramAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class HistogramAggregationTest extends TestCase
{

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new HistogramAggregation('foo');
        $aggregation->getArray();
    }

    public function testGetArrayExceptionWhenDontSendInterval(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new HistogramAggregation('foo', 'age');
        $aggregation->getArray();
    }

    public function testHistogramAggregationGetType(): void
    {
        $aggregation = new HistogramAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('histogram', $result);
    }

    public function testChildrenAggregationGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->addAggregation(new AggregationMock('name'));
        $aggregation->setField('age');
        $aggregation->setInterval(10);

        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10];

        self::assertEquals($expected, $result);
    }

    public function testIntervalGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->setField('age');
        $aggregation->setInterval(10);

        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10];

        self::assertEquals($expected, $result);
    }

    public function testExtendedBoundsGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->setField('age');
        $aggregation->setInterval(10);
        $aggregation->setExtendedBounds(0, 100);

        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10, 'extended_bounds' => ['min' => 0, 'max' => 100]];

        self::assertEquals(['min' => 0, 'max' => 100], $aggregation->getExtendedBounds());
        self::assertEquals($expected, $result);
    }

    public function testExtendedBoundsWithNullGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->setField('age');
        $aggregation->setInterval(10);
        $aggregation->setExtendedBounds(0, null);

        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10, 'extended_bounds' => ['min' => 0]];

        self::assertEquals(['min' => 0], $aggregation->getExtendedBounds());
        self::assertEquals($expected, $result);
    }

}
