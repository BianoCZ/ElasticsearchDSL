<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\BuilderInterface;
use LogicException;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filters-aggregation.html
 */
class FiltersAggregation extends AbstractBucketingAggregation
{

    /** @var array<string,array<mixed>> */
    private array $filters = [];

    private bool $anonymous = false;

    /**
     * @param array<string,\Biano\ElasticsearchDSL\BuilderInterface> $filters
     */
    public function __construct(string $name, array $filters = [], bool $anonymous = false)
    {
        parent::__construct($name);

        $this->setAnonymous($anonymous);

        foreach ($filters as $name => $filter) {
            $this->addFilter($filter, $anonymous ? null : $name);
        }
    }

    public function isAnonymous(): bool
    {
        return $this->anonymous;
    }

    public function setAnonymous(bool $anonymous): self
    {
        $this->anonymous = $anonymous;

        return $this;
    }

    /**
     * @return  array<string,array<mixed>>
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addFilter(BuilderInterface $filter, ?string $name = null): FiltersAggregation
    {
        if ($this->isAnonymous() === false && $name === null) {
            throw new LogicException('In not anonymous filters filter name must be set.');
        }

        if ($this->isAnonymous() === false && $name !== null) {
            $this->filters['filters'][$name] = $filter->toArray();
        } else {
            $this->filters['filters'][] = $filter->toArray();
        }

        return $this;
    }

    public function getType(): string
    {
        return 'filters';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return $this->getFilters();
    }

}
