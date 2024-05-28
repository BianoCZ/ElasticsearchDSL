<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Joining;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-parent-query.html
 */
class HasParentQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $parentType;

    private BuilderInterface $query;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $parentType, BuilderInterface $query, array $parameters = [])
    {
        $this->parentType = $parentType;
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'has_parent';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'parent_type' => $this->parentType,
            'query' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
