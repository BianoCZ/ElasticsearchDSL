<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Matrix;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;

abstract class AbstractMatrixAggregation extends AbstractAggregation
{

    /**
     * Matrix aggregations does not support nesting.
     */
    protected function supportsNesting(): bool
    {
        return false;
    }

}
