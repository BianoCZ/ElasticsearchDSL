<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use LogicException;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-geobounds-aggregation.html
 */
class GeoBoundsAggregation extends AbstractMetricAggregation
{

    private bool $wrapLongitude = true;

    public function __construct(string $name, ?string $field = null, bool $wrapLongitude = true)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        $this->setWrapLongitude($wrapLongitude);
    }

    public function isWrapLongitude(): bool
    {
        return $this->wrapLongitude;
    }

    public function setWrapLongitude(bool $wrapLongitude): self
    {
        $this->wrapLongitude = $wrapLongitude;

        return $this;
    }

    public function getType(): string
    {
        return 'geo_bounds';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getField() === null) {
            throw new LogicException('Geo bounds aggregation must have a field set.');
        }

        return [
            'field' => $this->getField(),
            'wrap_longitude' => $this->isWrapLongitude(),
        ];
    }

}
