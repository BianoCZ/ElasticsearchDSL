<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-stats-bucket-aggregation.html
 */
class StatsBucketAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'stats_bucket';
    }

}
