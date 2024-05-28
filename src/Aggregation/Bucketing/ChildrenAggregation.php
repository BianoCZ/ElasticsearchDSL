<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use LogicException;
use function array_filter;
use function count;
use function sprintf;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-children-aggregation.html
 */
class ChildrenAggregation extends AbstractBucketingAggregation
{

    private ?string $children = null;

    public function __construct(string $name, ?string $children = null)
    {
        parent::__construct($name);

        if ($children !== null) {
            $this->setChildren($children);
        }
    }

    public function getChildren(): ?string
    {
        return $this->children;
    }

    public function setChildren(string $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function getType(): string
    {
        return 'children';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if (count($this->getAggregations()) === 0) {
            throw new LogicException(sprintf('Children aggregation `%s` has no aggregations added', $this->getName()));
        }

        return array_filter([
            'type' => $this->getChildren(),
        ]);
    }

}
