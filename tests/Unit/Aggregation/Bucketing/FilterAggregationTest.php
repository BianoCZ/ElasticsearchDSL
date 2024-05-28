<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\FilterAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\HistogramAggregation;
use Biano\ElasticsearchDSL\Query\Compound\BoolQuery;
use Biano\ElasticsearchDSL\Query\MatchAllQuery;
use Biano\ElasticsearchDSL\Query\TermLevel\ExistsQuery;
use Biano\ElasticsearchDSL\Query\TermLevel\TermQuery;
use LogicException;
use PHPUnit\Framework\TestCase;

class FilterAggregationTest extends TestCase
{

    /**
     * Data provider for testToArray.
     */
    public function getToArrayData(): array
    {
        $out = [];

        // Case #0 filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $filter = new MatchAllQuery();

        $aggregation->setFilter($filter);

        $result = [
            'filter' => $filter->toArray(),
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #1 nested filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter($filter);

        $histogramAgg = new HistogramAggregation('acme', 'bar', 10);
        $aggregation->addAggregation($histogramAgg);

        $result = [
            'filter' => $filter->toArray(),
            'aggregations' => [
                $histogramAgg->getName() => $histogramAgg->toArray(),
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #2 testing bool filter.
        $aggregation = new FilterAggregation('test_agg');
        $matchAllFilter = new MatchAllQuery();
        $termFilter = new TermQuery('acme', 'foo');
        $boolFilter = new BoolQuery();
        $boolFilter->add($matchAllFilter);
        $boolFilter->add($termFilter);

        $aggregation->setFilter($boolFilter);

        $result = [
            'filter' => $boolFilter->toArray(),
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        return $out;
    }

    /**
     * Test for filter aggregation toArray() method.
     *
     * @dataProvider getToArrayData
     */
    public function testToArray(FilterAggregation $aggregation, array $expectedResult): void
    {
        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for setField().
     */
    public function testSetField(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('doesn\'t support `field` parameter');
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setField('test_field');
    }

    /**
     * Test for toArray() without setting a filter.
     */
    public function testToArrayNoFilter(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('has no filter added');
        $aggregation = new FilterAggregation('test_agg');
        $result = $aggregation->toArray();

        $this->assertEquals(
            [
                'aggregation' => [
                    'test_agg' => [
                        'filter' => [],
                    ],
                ],
            ],
            $result,
        );
    }

    /**
     * Test for toArray() with setting a filter.
     */
    public function testToArrayWithFilter(): void
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter(new ExistsQuery('test'));
        $result = $aggregation->toArray();

        $this->assertEquals(
            [
                'filter' => [
                    'exists' => ['field' => 'test'],
                ],
            ],
            $result,
        );
    }

    /**
     * Tests if filter can be passed to constructor.
     */
    public function testConstructorFilter(): void
    {
        $matchAllFilter = new MatchAllQuery();
        $aggregation = new FilterAggregation('test', $matchAllFilter);
        $this->assertEquals(
            [
                'filter' => $matchAllFilter->toArray(),
            ],
            $aggregation->toArray(),
        );
    }

}
