<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Metric;

use LogicException;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-geocentroid-aggregation.html
 */
class GeoCentroidAggregation extends AbstractMetricAggregation
{

    public function __construct(string $name, ?string $field = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }
    }

    public function getType(): string
    {
        return 'geo_centroid';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getField() === null) {
            throw new LogicException('Geo centroid aggregation must have a field set.');
        }

        return [
            'field' => $this->getField(),
        ];
    }

}
