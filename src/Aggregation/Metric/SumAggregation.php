<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-sum-aggregation.html
 */
class SumAggregation extends StatsAggregation
{

    public function getType(): string
    {
        return 'sum';
    }

}
