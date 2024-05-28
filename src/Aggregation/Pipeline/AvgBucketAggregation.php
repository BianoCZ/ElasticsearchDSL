<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-avg-bucket-aggregation.html
 */
class AvgBucketAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'avg_bucket';
    }

}
