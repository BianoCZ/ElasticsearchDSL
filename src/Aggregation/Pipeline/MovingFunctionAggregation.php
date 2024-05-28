<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-movfn-aggregation.html
 */
class MovingFunctionAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'moving_fn';
    }

}
