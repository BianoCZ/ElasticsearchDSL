<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-valuecount-aggregation.html
 */
class ValueCountAggregation extends StatsAggregation
{

    public function getType(): string
    {
        return 'value_count';
    }

}
