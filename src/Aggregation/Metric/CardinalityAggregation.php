<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use Biano\ElasticsearchDSL\ScriptAwareTrait;
use LogicException;
use function array_filter;
use function array_key_exists;
use function is_bool;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-cardinality-aggregation.html
 */
class CardinalityAggregation extends AbstractMetricAggregation
{

    use ScriptAwareTrait;

    private ?int $precisionThreshold = null;

    private ?bool $rehash = null;

    public function setPrecisionThreshold(int $precision): self
    {
        $this->precisionThreshold = $precision;

        return $this;
    }

    public function getPrecisionThreshold(): ?int
    {
        return $this->precisionThreshold;
    }

    public function isRehash(): ?bool
    {
        return $this->rehash;
    }

    public function setRehash(bool $rehash): self
    {
        $this->rehash = $rehash;

        return $this;
    }

    public function getType(): string
    {
        return 'cardinality';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        $data = array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'precision_threshold' => $this->getPrecisionThreshold(),
                'rehash' => $this->isRehash(),
            ],
            static function ($val) {
                return $val || is_bool($val);
            },
        );

        $this->checkRequiredFields($data);

        return $data;
    }

    /**
     * Checks if required fields are set.
     *
     * @param array<mixed> $data
     *
     * @throws \LogicException
     */
    private function checkRequiredFields(array $data): void
    {
        if (!array_key_exists('field', $data) && !array_key_exists('script', $data)) {
            throw new LogicException('Cardinality aggregation must have field or script set.');
        }
    }

}
