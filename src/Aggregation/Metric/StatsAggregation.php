<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use Biano\ElasticsearchDSL\ScriptAwareTrait;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html
 */
class StatsAggregation extends AbstractMetricAggregation
{

    use ScriptAwareTrait;

    public function __construct(string $name, ?string $field = null, ?string $script = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($script !== null) {
            $this->setScript($script);
        }
    }

    public function getType(): string
    {
        return 'stats';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter([
            'field' => $this->getField(),
            'script' => $this->getScript(),
        ]);
    }

}
