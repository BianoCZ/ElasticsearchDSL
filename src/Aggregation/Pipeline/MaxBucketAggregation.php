<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-max-bucket-aggregation.html
 */
class MaxBucketAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'max_bucket';
    }

}
