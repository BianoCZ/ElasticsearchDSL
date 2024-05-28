<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/2.3/search-aggregations-bucket-sampler-aggregation.html
 */
class SamplerAggregation extends AbstractBucketingAggregation
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

    public function getShardSize(): ?int
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
        return 'sampler';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'shard_size' => $this->getShardSize(),
            ],
        );
    }

}
