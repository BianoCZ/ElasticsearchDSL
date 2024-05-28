<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-field-masking-query.html
 */
class FieldMaskingSpanQuery implements SpanQueryInterface
{

    use ParametersTrait;

    private SpanQueryInterface $query;

    private string $field;

    public function __construct(string $field, SpanQueryInterface $query)
    {
        $this->setQuery($query);
        $this->setField($field);
    }

    public function getQuery(): SpanQueryInterface
    {
        return $this->query;
    }

    public function setQuery(SpanQueryInterface $query): self
    {
        $this->query = $query;

        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function getType(): string
    {
        return 'field_masking_span';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $output = [
            'query' => $this->getQuery()->toArray(),
            'field' => $this->getField(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }

}
