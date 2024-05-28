<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Geo;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-distance-query.html
 */
class GeoDistanceQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    private string $distance;

    private mixed $location;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, string $distance, mixed $location, array $parameters = [])
    {
        $this->field = $field;
        $this->distance = $distance;
        $this->location = $location;

        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_distance';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'distance' => $this->distance,
            $this->field => $this->location,
        ];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
