<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;
use function array_filter;
use function array_merge;
use function is_array;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-composite-aggregation.html
 */
class CompositeAggregation extends AbstractBucketingAggregation
{

    /** @var list<array<mixed>> */
    private array $sources = [];

    private ?int $size = null;

    /** @var array<mixed>|null */
    private ?array $after = null;

    /**
     * @param list<\Biano\ElasticsearchDSL\Aggregation\AbstractAggregation> $sources
     */
    public function __construct(string $name, array $sources = [])
    {
        parent::__construct($name);

        foreach ($sources as $agg) {
            $this->addSource($agg);
        }
    }

    /**
     * @return  list<array<mixed>>
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    public function addSource(AbstractAggregation $agg): self
    {
        $array = $agg->getArray();

        $array = is_array($array) ? array_merge($array, $agg->getParameters()) : $array;

        $this->sources[] = [
            $agg->getName() => [ $agg->getType() => $array ],
        ];

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

    /**
     * @return array<mixed>|null
     */
    public function getAfter(): ?array
    {
        return $this->after;
    }

    /**
     * @param array<mixed> $after
     */
    public function setAfter(array $after): self
    {
        $this->after = $after;

        return $this;
    }

    public function getType(): string
    {
        return 'composite';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter([
            'sources' => $this->getSources(),
            'size' => $this->getSize(),
            'after' => $this->getAfter(),
        ]);
    }

}
