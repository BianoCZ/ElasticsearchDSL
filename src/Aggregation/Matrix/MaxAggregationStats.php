<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Matrix;

use LogicException;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-matrix-stats-aggregation.html
 */
class MaxAggregationStats extends AbstractMatrixAggregation
{

    /** @var list<string> */
    private array $fields;

    /**
     * Used for multi value aggregation fields to pick a value.
     */
    private ?string $mode = null;

    /**
     * Defines how documents that are missing a value should be treated.
     *
     * @var array<mixed>
     */
    private ?array $missing = null;

    /**
     * @param list<string> $fields
     * @param array<mixed>|null $missing
     */
    public function __construct(string $name, array $fields, ?array $missing = null, ?string $mode = null)
    {
        parent::__construct($name);

        $this->setFields($fields);

        if ($missing !== null) {
            $this->setMissing($missing);
        }

        if ($mode !== null) {
            $this->setMode($mode);
        }
    }

    public function setField(string $field): self
    {
        throw new LogicException('Max aggregation stats doesn\'t support `field` parameter');
    }

    /**
     * @return list<string>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param list<string> $fields
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @return array<mixed>|null
     */
    public function getMissing(): ?array
    {
        return $this->missing;
    }

    /**
     * @param array<mixed> $missing
     */
    public function setMissing(array $missing): self
    {
        $this->missing = $missing;

        return $this;
    }

    public function getType(): string
    {
        return 'matrix_stats';
    }

    /**
     * @inheritDoc
     */
    protected function getArray(): array
    {
        return array_filter([
            'fields' => $this->getField(),
            'mode' => $this->getMode(),
            'missing' => $this->getMissing(),
        ]);
    }

}
