<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-multi-term-query.html
 */
class SpanMultiTermQuery implements SpanQueryInterface
{

    use ParametersTrait;

    private BuilderInterface $query;

    /**
     * Accepts one of fuzzy, prefix, term range, wildcard, regexp query.
     *
     * @param array<string,mixed> $parameters
     */
    public function __construct(BuilderInterface $query, array $parameters = [])
    {
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'span_multi';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [];
        $query['match'] = $this->query->toArray();
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
