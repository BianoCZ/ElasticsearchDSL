<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use Biano\ElasticsearchDSL\ScriptAwareTrait;
use LogicException;
use function array_filter;
use function array_key_exists;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-aggregation.html
 */
class PercentilesAggregation extends AbstractMetricAggregation
{

    use ScriptAwareTrait;

    /** @var list<int|float>|null */
    private ?array $percents = null;

    private ?int $compression = null;

    /**
     * @param list<int|float>|null $percents
     */
    public function __construct(
        string $name,
        ?string $field = null,
        ?array $percents = null,
        ?string $script = null,
        ?int $compression = null,
    ) {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($percents !== null) {
            $this->setPercents($percents);
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
    public function getPercents(): ?array
    {
        return $this->percents;
    }

    /**
     * @param list<int|float> $percents
     */
    public function setPercents(array $percents): self
    {
        $this->percents = $percents;

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
        return 'percentiles';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        $data = array_filter(
            [
                'compression' => $this->getCompression(),
                'percents' => $this->getPercents(),
                'field' => $this->getField(),
                'script' => $this->getScript(),
            ],
            static fn ($val): bool => $val !== null,
        );

        $this->isRequiredParametersSet($data);

        return $data;
    }

    /**
     * @param array<mixed> $data
     *
     * @throws \LogicException
     */
    private function isRequiredParametersSet(array $data): void
    {
        if (!array_key_exists('field', $data) && !array_key_exists('script', $data)) {
            throw new LogicException('Percentiles aggregation must have field or script set.');
        }
    }

}
