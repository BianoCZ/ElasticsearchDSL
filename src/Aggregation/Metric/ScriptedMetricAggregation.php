<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-scripted-metric-aggregation.html
 */
class ScriptedMetricAggregation extends AbstractMetricAggregation
{

    private mixed $initScript;

    private mixed $mapScript;

    private mixed $combineScript;

    private mixed $reduceScript;

    public function __construct(
        string $name,
        mixed $initScript = null,
        mixed $mapScript = null,
        mixed $combineScript = null,
        mixed $reduceScript = null,
    ) {
        parent::__construct($name);

        $this->setInitScript($initScript);
        $this->setMapScript($mapScript);
        $this->setCombineScript($combineScript);
        $this->setReduceScript($reduceScript);
    }

    public function getInitScript(): mixed
    {
        return $this->initScript;
    }

    public function setInitScript(mixed $initScript): self
    {
        $this->initScript = $initScript;

        return $this;
    }

    public function getMapScript(): mixed
    {
        return $this->mapScript;
    }

    public function setMapScript(mixed $mapScript): self
    {
        $this->mapScript = $mapScript;

        return $this;
    }

    public function getCombineScript(): mixed
    {
        return $this->combineScript;
    }

    public function setCombineScript(mixed $combineScript): self
    {
        $this->combineScript = $combineScript;

        return $this;
    }

    public function getReduceScript(): mixed
    {
        return $this->reduceScript;
    }

    public function setReduceScript(mixed $reduceScript): self
    {
        $this->reduceScript = $reduceScript;

        return $this;
    }

    public function getType(): string
    {
        return 'scripted_metric';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'init_script' => $this->getInitScript(),
                'map_script' => $this->getMapScript(),
                'combine_script' => $this->getCombineScript(),
                'reduce_script' => $this->getReduceScript(),
            ],
        );
    }

}
