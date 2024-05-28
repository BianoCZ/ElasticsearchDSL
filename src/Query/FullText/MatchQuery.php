<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\FullText;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class MatchQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    private string $query;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, string $query, array $parameters = [])
    {
        $this->field = $field;
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'match';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'query' => $this->query,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }

}
