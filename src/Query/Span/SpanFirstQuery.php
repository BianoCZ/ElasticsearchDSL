<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-first-query.html
 */
class SpanFirstQuery implements SpanQueryInterface
{

    use ParametersTrait;

    private SpanQueryInterface $query;

    private int $end;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(SpanQueryInterface $query, int $end, array $parameters = [])
    {
        $this->query = $query;
        $this->end = $end;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'span_first';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [];
        $query['match'] = $this->query->toArray();
        $query['end'] = $this->end;
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
