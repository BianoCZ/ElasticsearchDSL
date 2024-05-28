<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Joining;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-has-child-query.html
 */
class HasChildQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $type;

    private BuilderInterface $query;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $type, BuilderInterface $query, array $parameters = [])
    {
        $this->type = $type;
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'has_child';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'type' => $this->type,
            'query' => $this->query->toArray(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
