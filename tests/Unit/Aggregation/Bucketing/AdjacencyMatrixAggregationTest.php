<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\AdjacencyMatrixAggregation;
use Biano\ElasticsearchDSL\BuilderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use function assert;

/**
 * Unit test for adjacency matrix aggregation.
 */
class AdjacencyMatrixAggregationTest extends TestCase
{

    /**
     * Test GetArray method.
     */
    public function testFiltersAggregationGetArray(): void
    {
        $mock = $this->createMock(BuilderInterface::class);
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $aggregation->addFilter('name', $mock);
        $result = $aggregation->getArray();
        $this->assertArrayHasKey('filters', $result);
    }

    /**
     * Tests getType method.
     */
    public function testFiltersAggregationGetType(): void
    {
        $aggregation = new AdjacencyMatrixAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('adjacency_matrix', $result);
    }

    /**
     * Test for filter aggregation toArray() method.
     */
    public function testToArray(): void
    {
        $aggregation = new AdjacencyMatrixAggregation('test_agg');
        $filter = $this->createMock(BuilderInterface::class);
        $filter->expects(self::any())->method('toArray')
            ->willReturn(['test_field' => ['test_value' => 'test']]);

        $aggregation->addFilter('first', $filter);
        $aggregation->addFilter('second', $filter);

        $results = $aggregation->toArray();
        $expected = [
            'adjacency_matrix' => [
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
     * Tests if filters can be passed to the constructor.
     */
    public function testFilterConstructor(): void
    {
        $builderInterface1 = $this->getMockForAbstractClass(BuilderInterface::class);
        assert($builderInterface1 instanceof BuilderInterface || $builderInterface1 instanceof MockObject);
        $builderInterface2 = $this->getMockForAbstractClass(BuilderInterface::class);
        assert($builderInterface2 instanceof BuilderInterface || $builderInterface2 instanceof MockObject);

        $aggregation = new AdjacencyMatrixAggregation(
            'test',
            [
                'filter1' => $builderInterface1,
                'filter2' => $builderInterface2,
            ],
        );

        $this->assertSame(
            [
                'adjacency_matrix' => [
                    'filters' => [
                        'filter1' => [],
                        'filter2' => [],
                    ],
                ],
            ],
            $aggregation->toArray(),
        );

        $aggregation = new AdjacencyMatrixAggregation('test');

        $this->assertSame(
            [
                'adjacency_matrix' => [
                    'filters' => [],
                ],
            ],
            $aggregation->toArray(),
        );
    }

}
