<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-not-query.html
 */
class SpanNotQuery implements SpanQueryInterface
{

    use ParametersTrait;

    private SpanQueryInterface $include;

    private SpanQueryInterface $exclude;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(SpanQueryInterface $include, SpanQueryInterface $exclude, array $parameters = [])
    {
        $this->include = $include;
        $this->exclude = $exclude;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'span_not';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'include' => $this->include->toArray(),
            'exclude' => $this->exclude->toArray(),
        ];

        return [$this->getType() => $this->processArray($query)];
    }

}
