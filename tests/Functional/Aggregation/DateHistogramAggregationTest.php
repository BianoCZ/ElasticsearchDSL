<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Functional\Aggregation;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\DateHistogramAggregation;
use Biano\ElasticsearchDSL\Search;
use Biano\ElasticsearchDSL\Tests\Functional\AbstractElasticsearchTestCase;
use function count;

class DateHistogramAggregationTest extends AbstractElasticsearchTestCase
{

    /**
     * @inheritDoc
     */
    protected function getDataArray(): array
    {
        return [
            'products' => [
                [
                    'title' => 'acme',
                    'price' => 10,
                    'created_at' => '2022-01-01T00:02:00Z',
                ],
                [
                    'title' => 'foo',
                    'price' => 20,
                    'created_at' => '2022-01-01T00:01:00Z',
                ],
                [
                    'title' => 'bar',
                    'price' => 10,
                    'created_at' => '2022-01-01T00:03:00Z',
                ],
            ],
        ];
    }

    public function testDateHistogramWithMinuteCalendarInterval(): void
    {
        $histogram = new DateHistogramAggregation('dates', 'created_at');
        $histogram->setCalendarInterval('minute');

        $search = new Search();
        $search->addAggregation($histogram);

        $results = $this->executeSearch($search, true);

        self::assertCount(count($this->getDataArray()['products']), $results['aggregations']['dates']['buckets']);
    }

    public function testDateHistogramWithMonthCalendarInterval(): void
    {
        $histogram = new DateHistogramAggregation('dates', 'created_at');
        $histogram->setCalendarInterval('month');

        $search = new Search();
        $search->addAggregation($histogram);

        $results = $this->executeSearch($search, true);

        self::assertCount(1, $results['aggregations']['dates']['buckets']);
    }

    public function testDateHistogramWitMinuteFixedInterval(): void
    {
        $histogram = new DateHistogramAggregation('dates', 'created_at');
        $histogram->setFixedInterval('2m');

        $search = new Search();
        $search->addAggregation($histogram);

        $results = $this->executeSearch($search, true);

        self::assertCount(2, $results['aggregations']['dates']['buckets']);
    }

}
