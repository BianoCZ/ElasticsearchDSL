<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-serialdiff-aggregation.html
 */
class SerialDifferencingAggregation extends AbstractPipelineAggregation
{

    public function getType(): string
    {
        return 'serial_diff';
    }

}
