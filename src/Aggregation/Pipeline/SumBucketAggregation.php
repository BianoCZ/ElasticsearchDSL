<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-sum-bucket-aggregation.html
 */
class SumBucketAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'sum_bucket';
    }

}
