<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use Biano\ElasticsearchDSL\ScriptAwareTrait;
use function array_filter;
use function is_numeric;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-extendedstats-aggregation.html
 */
class ExtendedStatsAggregation extends AbstractMetricAggregation
{

    use ScriptAwareTrait;

    private ?int $sigma = null;

    public function __construct(string $name, ?string $field = null, ?int $sigma = null, ?string $script = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($sigma !== null) {
            $this->setSigma($sigma);
        }

        if ($script !== null) {
            $this->setScript($script);
        }
    }

    public function getSigma(): ?int
    {
        return $this->sigma;
    }

    public function setSigma(int $sigma): self
    {
        $this->sigma = $sigma;

        return $this;
    }

    public function getType(): string
    {
        return 'extended_stats';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'sigma' => $this->getSigma(),
            ],
            static function ($val) {
                return $val || is_numeric($val);
            },
        );
    }

}
