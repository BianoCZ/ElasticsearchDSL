<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Sort;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/filter-dsl-nested-filter.html
 */
class NestedSort implements BuilderInterface
{

    use ParametersTrait;

    private string $path;

    private ?BuilderInterface $filter;

    private ?BuilderInterface $nestedFilter = null;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $path, ?BuilderInterface $filter = null, array $parameters = [])
    {
        $this->path = $path;
        $this->filter = $filter;
        $this->setParameters($parameters);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilter(): ?BuilderInterface
    {
        return $this->filter;
    }

    public function getNestedFilter(): ?BuilderInterface
    {
        return $this->nestedFilter;
    }

    public function setNestedFilter(BuilderInterface $nestedFilter): self
    {
        $this->nestedFilter = $nestedFilter;

        return $this;
    }

    public function getType(): string
    {
        return 'nested';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $data = [
            'path' => $this->getPath(),
        ];

        if ($this->getFilter() !== null) {
            $data['filter'] = $this->getFilter()->toArray();
        }

        if ($this->getNestedFilter() !== null) {
            $data[$this->getType()] = $this->getNestedFilter()->toArray();
        }

        return $this->processArray($data);
    }

}
