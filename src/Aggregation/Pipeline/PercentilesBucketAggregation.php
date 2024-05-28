<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-percentiles-bucket-aggregation.html
 */
class PercentilesBucketAggregation extends AbstractPipelineAggregation
{

    /** @var list<int|float>|null */
    private ?array $percents = null;

    public function getType(): string
    {
        return 'percentiles_bucket';
    }

    /**
     * @return list<int|float>|null
     */
    public function getPercents(): ?array
    {
        return $this->percents;
    }

    /**
     * @param list<int|float> $percents
     */
    public function setPercents(array $percents): self
    {
        $this->percents = $percents;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter([
            'buckets_path' => $this->getBucketsPath(),
            'percents' => $this->getPercents(),
        ]);
    }

}
