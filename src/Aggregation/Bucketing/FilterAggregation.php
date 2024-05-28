<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\BuilderInterface;
use LogicException;
use function sprintf;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filter-aggregation.html
 */
class FilterAggregation extends AbstractBucketingAggregation
{

    private ?BuilderInterface $filter = null;

    public function __construct(string $name, ?BuilderInterface $filter = null)
    {
        parent::__construct($name);

        if ($filter !== null) {
            $this->setFilter($filter);
        }
    }

    public function setField(string $field): self
    {
        throw new LogicException("Filter aggregation doesn't support `field` parameter");
    }

    public function getFilter(): ?BuilderInterface
    {
        return $this->filter;
    }

    public function setFilter(BuilderInterface $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function getType(): string
    {
        return 'filter';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getFilter() === null) {
            throw new LogicException(sprintf('Filter aggregation `%s` has no filter added', $this->getName()));
        }

        return $this->getFilter()->toArray();
    }

}
