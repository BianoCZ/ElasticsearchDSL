<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\FullText;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
 */
class QueryStringQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $query;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $query, array $parameters = [])
    {
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getType(): string
    {
        return 'query_string';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'query' => $this->getQuery(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
