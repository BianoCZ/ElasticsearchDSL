<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-min-bucket-aggregation.html
 */
class MinBucketAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'min_bucket';
    }

}
