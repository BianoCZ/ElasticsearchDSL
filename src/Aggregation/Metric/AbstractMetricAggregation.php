<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;

abstract class AbstractMetricAggregation extends AbstractAggregation
{

    /**
     * Metric aggregations does not support nesting.
     */
    protected function supportsNesting(): bool
    {
        return false;
    }

}
