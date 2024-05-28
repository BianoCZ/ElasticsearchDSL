<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-extended-stats-bucket-aggregation.html
 */
class ExtendedStatsBucketAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'extended_stats_bucket';
    }

}
