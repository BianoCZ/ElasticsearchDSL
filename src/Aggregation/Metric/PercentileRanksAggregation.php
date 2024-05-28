<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use Biano\ElasticsearchDSL\ScriptAwareTrait;
use LogicException;
use function array_filter;
use function array_key_exists;
use function is_numeric;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-rank-aggregation.html
 */
class PercentileRanksAggregation extends AbstractMetricAggregation
{

    use ScriptAwareTrait;

    /** @var list<int|float>|null */
    private ?array $values = null;

    private ?int $compression = null;

    /**
     * @param list<int|float>|null $values
     */
    public function __construct(string $name, ?string $field = null, ?array $values = null, ?string $script = null, ?int $compression = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($values !== null) {
            $this->setValues($values);
        }

        if ($script !== null) {
            $this->setScript($script);
        }

        if ($compression !== null) {
            $this->setCompression($compression);
        }
    }

    /**
     * @return list<int|float>|null
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * @param list<int|float> $values
     */
    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }

    public function getCompression(): ?int
    {
        return $this->compression;
    }

    public function setCompression(int $compression): self
    {
        $this->compression = $compression;

        return $this;
    }

    public function getType(): string
    {
        return 'percentile_ranks';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        $out = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'values' => $this->getValues(),
                'compression' => $this->getCompression(),
            ],
            static function ($val) {
                return $val || is_numeric($val);
            },
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    /**
     * @param array<mixed> $data
     *
     * @throws \LogicException
     */
    private function isRequiredParametersSet(array $data): bool
    {
        if (
            array_key_exists('field', $data) && array_key_exists('values', $data)
            || (array_key_exists('script', $data) && array_key_exists('values', $data))
        ) {
            return true;
        }

        throw new LogicException('Percentile ranks aggregation must have field and values or script and values set.');
    }

}
