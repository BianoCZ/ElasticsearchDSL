<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;

abstract class AbstractBucketingAggregation extends AbstractAggregation
{

    /**
     * Bucketing aggregations supports nesting.
     */
    protected function supportsNesting(): bool
    {
        return true;
    }

}
