<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Joining;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
 */
class NestedQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $path;

    private BuilderInterface $query;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $path, BuilderInterface $query, array $parameters = [])
    {
        $this->path = $path;
        $this->query = $query;
        $this->parameters = $parameters;
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
        return [
            $this->getType() => $this->processArray(
                [
                    'path' => $this->path,
                    'query' => $this->query->toArray(),
                ],
            ),
        ];
    }

    /**
     * Returns nested query object.
     */
    public function getQuery(): BuilderInterface
    {
        return $this->query;
    }

    /**
     * Returns path this query is set for.
     */
    public function getPath(): string
    {
        return $this->path;
    }

}
