<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\CompositeAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;

class CompositeAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $compositeAgg->addSource($termsAgg);

        $expected = [
            'composite' => [
                'sources' => [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field'] ],
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $compositeAgg->toArray());
    }

    public function testToArrayWithSizeAndAfter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $compositeAgg->addSource($termsAgg);
        $compositeAgg->setSize(5);
        $compositeAgg->setAfter(['test_term_agg' => 'test']);

        $expected = [
            'composite' => [
                'sources' => [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field'] ],
                    ],
                ],
                'size' => 5,
                'after' => ['test_term_agg' => 'test'],
            ],
        ];

        self::assertEquals($expected, $compositeAgg->toArray());
    }

    public function testGetSize(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $compositeAgg->setSize(5);

        self::assertEquals(5, $compositeAgg->getSize());
    }

    public function testGetAfter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_test_agg');
        $compositeAgg->setAfter(['test_term_agg' => 'test']);

        self::assertEquals(['test_term_agg' => 'test'], $compositeAgg->getAfter());
    }

    public function testGetType(): void
    {
        $aggregation = new CompositeAggregation('foo');
        $result = $aggregation->getType();

        self::assertEquals('composite', $result);
    }

    public function testTermsSourceWithOrderParameter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $termsAgg->addParameter('order', 'asc');
        $compositeAgg->addSource($termsAgg);

        $expected = [
            'composite' => [
                'sources' => [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field', 'order' => 'asc'] ],
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $compositeAgg->toArray());
    }

    public function testTermsSourceWithDescOrderParameter(): void
    {
        $compositeAgg = new CompositeAggregation('composite_with_order');
        $termsAgg = new TermsAggregation('test_term_agg', 'test_field');
        $termsAgg->addParameter('order', 'desc');
        $compositeAgg->addSource($termsAgg);

        $expected = [
            'composite' => [
                'sources' => [
                    [
                        'test_term_agg' => [ 'terms' => ['field' => 'test_field', 'order' => 'desc'] ],
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $compositeAgg->toArray());
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

        $expected = [
            'composite' => [
                'sources' => [
                    [
                        'test_term_agg_1' => [ 'terms' => ['field' => 'test_field', 'order' => 'desc'] ],
                    ],
                    [
                        'test_term_agg_2' => [ 'terms' => ['field' => 'test_field', 'order' => 'asc'] ],
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $compositeAgg->toArray());
    }

}
