<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\FiltersAggregation;
use Biano\ElasticsearchDSL\BuilderInterface;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use function assert;

/**
 * Unit test for filters aggregation.
 */
class FiltersAggregationTest extends TestCase
{

    /**
     * Test if exception is thrown when not anonymous filter is without name.
     */
    public function testIfExceptionIsThrown(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('In not anonymous filters filter name must be set.');
        $mock = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $aggregation = new FiltersAggregation('test_agg');
        $aggregation->addFilter($mock);
    }

    /**
     * Test GetArray method.
     */
    public function testFiltersAggregationGetArray(): void
    {
        $mock = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $aggregation = new FiltersAggregation('test_agg');
        $aggregation->setAnonymous(true);
        $aggregation->addFilter($mock, 'name');
        $result = $aggregation->getArray();
        $this->assertArrayHasKey('filters', $result);
    }

    /**
     * Tests getType method.
     */
    public function testFiltersAggregationGetType(): void
    {
        $aggregation = new FiltersAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('filters', $result);
    }

    /**
     * Test for filter aggregation toArray() method.
     */
    public function testToArray(): void
    {
        $aggregation = new FiltersAggregation('test_agg');
        $filter = $this->getMockBuilder(BuilderInterface::class)
            ->setMethods(['toArray', 'getType'])
            ->getMockForAbstractClass();
        $filter->expects($this->any())
            ->method('toArray')
            ->willReturn(['test_field' => ['test_value' => 'test']]);

        $aggregation->addFilter($filter, 'first');
        $aggregation->addFilter($filter, 'second');
        $results = $aggregation->toArray();
        $expected = [
            'filters' => [
                'filters' => [
                    'first' => [
                        'test_field' => ['test_value' => 'test'],
                    ],
                    'second' => [
                        'test_field' => ['test_value' => 'test'],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $results);
    }

    /**
     * Tests if filters can be passed to constructor.
     */
    public function testConstructorFilter(): void
    {
        $builderInterface1 = $this->getMockForAbstractClass(BuilderInterface::class);
        assert($builderInterface1 instanceof BuilderInterface || $builderInterface1 instanceof MockObject);
        $builderInterface2 = $this->getMockForAbstractClass(BuilderInterface::class);
        assert($builderInterface2 instanceof BuilderInterface || $builderInterface2 instanceof MockObject);

        $aggregation = new FiltersAggregation(
            'test',
            [
                'filter1' => $builderInterface1,
                'filter2' => $builderInterface2,
            ],
        );

        $this->assertSame(
            [
                'filters' => [
                    'filters' => [
                        'filter1' => [],
                        'filter2' => [],
                    ],
                ],
            ],
            $aggregation->toArray(),
        );

        $aggregation = new FiltersAggregation(
            'test',
            [
                'filter1' => $builderInterface1,
                'filter2' => $builderInterface2,
            ],
            true,
        );

        $this->assertSame(
            [
                'filters' => [
                    'filters' => [
                        [],
                        [],
                    ],
                ],
            ],
            $aggregation->toArray(),
        );
    }

}
