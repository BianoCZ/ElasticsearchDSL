<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use LogicException;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geohashgrid-aggregation.html
 */
class GeoHashGridAggregation extends AbstractBucketingAggregation
{

    private ?int $precision = null;

    private ?int $size = null;

    private ?int $shardSize = null;

    public function __construct(string $name, ?string $field = null, ?int $precision = null, ?int $size = null, ?int $shardSize = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($precision !== null) {
            $this->setPrecision($precision);
        }

        if ($size !== null) {
            $this->setSize($size);
        }

        if ($shardSize !== null) {
            $this->setShardSize($shardSize);
        }
    }

    public function getPrecision(): ?int
    {
        return $this->precision;
    }

    public function setPrecision(int $precision): self
    {
        $this->precision = $precision;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
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
        return 'geohash_grid';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getField() === null) {
            throw new LogicException('Geo bounds aggregation must have a field set.');
        }

        return array_filter([
            'field' => $this->getField(),
            'precision' => $this->getPrecision(),
            'size' => $this->getSize(),
            'shard_size' => $this->getShardSize(),
        ]);
    }

}
