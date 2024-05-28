<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/5.1/search-aggregations-bucket-diversified-sampler-aggregation.html
 */
class DiversifiedSamplerAggregation extends AbstractBucketingAggregation
{

    /**
     * Defines how many results will be received from each shard
     */
    private ?int $shardSize = null;

    public function __construct(string $name, ?string $field = null, ?int $shardSize = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($shardSize !== null) {
            $this->setShardSize($shardSize);
        }
    }

    public function getShardSize(): mixed
    {
        return $this->shardSize;
    }

    public function setShardSize(int $shardSize): self
    {
        $this->shardSize = $shardSize;

        return $this;
    }

    public function getType(): string
    {
        return 'diversified_sampler';
    }

    /**
     * @inheritdoc
     */
    protected function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ],
        );
    }

}
