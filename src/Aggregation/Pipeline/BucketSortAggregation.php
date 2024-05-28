<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Sort\FieldSort;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-sort-aggregation.html
 */
class BucketSortAggregation extends AbstractPipelineAggregation
{

    /** @var list<array<mixed>> */
    private array $sort = [];

    private ?int $size = null;

    private ?int $from = null;

    /**
     * @return list<array<mixed>>
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    public function addSort(FieldSort $sort): self
    {
        $this->sort[] = $sort->toArray();

        return $this;
    }

    /**
     * @param list<\Biano\ElasticsearchDSL\Sort\FieldSort> $sorts
     */
    public function setSort(array $sorts): self
    {
        foreach ($sorts as $sort) {
            $this->addSort($sort);
        }

        return $this;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Return from.
     */
    public function getFrom(): ?int
    {
        return $this->from;
    }

    public function setFrom(int $from): self
    {
        $this->from = $from;

        return $this;
    }

    public function getType(): string
    {
        return 'bucket_sort';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'buckets_path' => $this->getBucketsPath(),
                'sort' => $this->getSort(),
                'size' => $this->getSize(),
                'from' => $this->getFrom(),
            ],
        );
    }

}
