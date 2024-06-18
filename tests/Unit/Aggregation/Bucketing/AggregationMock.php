<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;

class AggregationMock extends AbstractAggregation
{

    public function getType(): string
    {
        return '';
    }

    protected function supportsNesting(): bool
    {
        return false;
    }

    /**
     * @return array<mixed>
     */
    protected function getArray(): array
    {
        return [];
    }

}
