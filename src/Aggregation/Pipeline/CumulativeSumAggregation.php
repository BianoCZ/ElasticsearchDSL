<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-cumulative-sum-aggregation.html
 */
class CumulativeSumAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'cumulative_sum';
    }

}
