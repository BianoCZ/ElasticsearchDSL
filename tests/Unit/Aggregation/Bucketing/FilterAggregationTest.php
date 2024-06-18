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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FilterAggregationTest extends TestCase
{

    /**
     * Test for filter aggregation toArray() method.
     *
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(FilterAggregation $aggregation, array $expected): void
    {
        self::assertEquals($expected, $aggregation->toArray());
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        // Case #0 filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $filter = new MatchAllQuery();

        $aggregation->setFilter($filter);

        $expected = [
            'filter' => $filter->toArray(),
        ];

        yield [
            'aggregation' => $aggregation,
            'expected' => $expected,
        ];

        // Case #1 nested filter aggregation.
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter($filter);

        $histogramAgg = new HistogramAggregation('acme', 'bar', 10);
        $aggregation->addAggregation($histogramAgg);

        $expected = [
            'filter' => $filter->toArray(),
            'aggregations' => [
                $histogramAgg->getName() => $histogramAgg->toArray(),
            ],
        ];

        yield [
            'aggregation' => $aggregation,
            'expected' => $expected,
        ];

        // Case #2 testing bool filter.
        $aggregation = new FilterAggregation('test_agg');
        $matchAllFilter = new MatchAllQuery();
        $termFilter = new TermQuery('acme', 'foo');
        $boolFilter = new BoolQuery();
        $boolFilter->add($matchAllFilter);
        $boolFilter->add($termFilter);

        $aggregation->setFilter($boolFilter);

        $expected = [
            'filter' => $boolFilter->toArray(),
        ];

        yield [
            'aggregation' => $aggregation,
            'expected' => $expected,
        ];
    }

    public function testSetField(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('doesn\'t support `field` parameter');

        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setField('test_field');
    }

    public function testToArrayNoFilter(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('has no filter added');

        $aggregation = new FilterAggregation('test_agg');

        $result = $aggregation->toArray();
        $expected = [
            'aggregation' => [
                'test_agg' => [
                    'filter' => [],
                ],
            ],
        ];

        self::assertEquals($expected, $result);
    }

    public function testToArrayWithFilter(): void
    {
        $aggregation = new FilterAggregation('test_agg');
        $aggregation->setFilter(new ExistsQuery('test'));

        $result = $aggregation->toArray();
        $expected = [
            'filter' => [
                'exists' => ['field' => 'test'],
            ],
        ];

        self::assertEquals($expected, $result);
    }

    public function testConstructorFilter(): void
    {
        $matchAllFilter = new MatchAllQuery();
        $aggregation = new FilterAggregation('test', $matchAllFilter);

        self::assertEquals(
            [
                'filter' => $matchAllFilter->toArray(),
            ],
            $aggregation->toArray(),
        );
    }

}
