<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-near-query.html
 */
class SpanNearQuery extends SpanOrQuery implements SpanQueryInterface
{

    private int $slop;

    public function getSlop(): int
    {
        return $this->slop;
    }

    public function setSlop(int $slop): self
    {
        $this->slop = $slop;

        return $this;
    }

    public function getType(): string
    {
        return 'span_near';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [];
        foreach ($this->getQueries() as $type) {
            $query['clauses'][] = $type->toArray();
        }

        $query['slop'] = $this->getSlop();
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
