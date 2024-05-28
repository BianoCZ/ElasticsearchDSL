<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-or-query.html
 */
class SpanOrQuery implements SpanQueryInterface
{

    use ParametersTrait;

    /** @var list<\Biano\ElasticsearchDSL\Query\Span\SpanQueryInterface> */
    private array $queries = [];

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * Add span query.
     */
    public function addQuery(SpanQueryInterface $query): self
    {
        $this->queries[] = $query;

        return $this;
    }

    /**
     * @return list<\Biano\ElasticsearchDSL\Query\Span\SpanQueryInterface>
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    public function getType(): string
    {
        return 'span_or';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [];
        foreach ($this->queries as $type) {
            $query['clauses'][] = $type->toArray();
        }

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
