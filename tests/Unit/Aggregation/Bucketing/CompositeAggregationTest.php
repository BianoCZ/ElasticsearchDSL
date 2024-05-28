<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\CompositeAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;

class CompositeAggregationTest extends TestCase
{

    /**
     * Test for composite aggregation toArray() method exception.
     */
    public function testToArray(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field'] ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

    /**
     * Test for composite aggregation toArray() method with size and after part.
     */
    public function testToArrayWithSizeAndAfter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $compositeAgg->addSource($termsAgg);
        $compositeAgg->setSize(5);
        $compositeAgg->setAfter(['test_term_agg' => 'test']);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field'] ],
                    ],
                ],
                'size' => 5,
                'after' => ['test_term_agg' => 'test'],
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

    /**
     * Test for composite aggregation getSize() method.
     */
    public function testGetSize(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $compositeAgg->setSize(5);

        $this->assertEquals(5, $compositeAgg->getSize());
    }

    /**
     * Test for composite aggregation getAfter() method.
     */
    public function testGetAfter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $compositeAgg->setAfter(['test_term_agg' => 'test']);

        $this->assertEquals(['test_term_agg' => 'test'], $compositeAgg->getAfter());
    }

    /**
     * Tests getType method.
     */
    public function testGetType(): void
    {
        $aggregation = new CompositeAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('composite', $result);
    }

    public function testTermsSourceWithOrderParameter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $termsAgg->addParameter('order', 'asc');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field', 'order' => 'asc'] ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

    public function testTermsSourceWithDescOrderParameter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $termsAgg->addParameter('order', 'desc');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field', 'order' => 'desc'] ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

    public function testMultipleSourcesWithDifferentOrders(): void
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');

        $termsAgg = new TermsAggregation('test_term_agg_1', 'test_field');
        $termsAgg->addParameter('order', 'desc');
        $compositeAgg->addSource($termsAgg);

        $termsAgg = new TermsAggregation('test_term_agg_2', 'test_field');
        $termsAgg->addParameter('order', 'asc');
        $compositeAgg->addSource($termsAgg);

        $expectedResult = [
            'composite' => [
                'sources' =>  [
                    [
                        'test_term_agg_1' => [ 'terms' => ['field' => 'test_field', 'order' => 'desc'] ],
                    ],
                    [
                        'test_term_agg_2' => [ 'terms' => ['field' => 'test_field', 'order' => 'asc'] ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $compositeAgg->toArray());
    }

}
