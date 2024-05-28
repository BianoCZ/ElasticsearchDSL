<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\HistogramAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class HistogramAggregationTest extends TestCase
{

    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $aggregation = new HistogramAggregation('foo');
        $aggregation->getArray();
    }

    /**
     * Tests if ChildrenAggregation#getArray throws exception when expected.
     */
    public function testGetArrayExceptionWhenDontSendInterval(): void
    {
        $this->expectException(LogicException::class);
        $aggregation = new HistogramAggregation('foo', 'age');
        $aggregation->getArray();
    }

    /**
     * Tests getType method.
     */
    public function testHistogramAggregationGetType(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('histogram', $result);
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
        $aggregation = new HistogramAggregation('foo');
        $aggregation->addAggregation($mock);
        $aggregation->setField('age');
        $aggregation->setInterval(10);
        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method.
     */
    public function testIntervalGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->setField('age');
        $aggregation->setInterval(10);
        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method.
     */
    public function testExtendedBoundsGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->setField('age');
        $aggregation->setInterval(10);
        $aggregation->setExtendedBounds(0, 100);
        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10, 'extended_bounds' => ['min' => 0, 'max' => 100]];
        $this->assertEquals(['min' => 0, 'max' => 100], $aggregation->getExtendedBounds());
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method.
     */
    public function testExtendedBoundsWithNullGetArray(): void
    {
        $aggregation = new HistogramAggregation('foo');
        $aggregation->setField('age');
        $aggregation->setInterval(10);
        $aggregation->setExtendedBounds(0, null);
        $result = $aggregation->getArray();
        $expected = ['field' => 'age', 'interval' => 10, 'extended_bounds' => ['min' => 0]];
        $this->assertEquals(['min' => 0], $aggregation->getExtendedBounds());
        $this->assertEquals($expected, $result);
    }

}
