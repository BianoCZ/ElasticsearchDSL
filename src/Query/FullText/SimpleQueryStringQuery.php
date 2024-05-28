<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\FullText;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-simple-query-string-query.html
 */
class SimpleQueryStringQuery implements BuilderInterface
{

    use ParametersTrait;

    /** @var string The actual query to be parsed. */
    private string $query;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $query, array $parameters = [])
    {
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'simple_query_string';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'query' => $this->query,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
