<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Geo;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-polygon-query.html
 */
class GeoPolygonQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    /** @var list<array<string,float|int>> */
    private array $points;

    /**
     * @param list<array<string,float|int>> $points
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, array $points = [], array $parameters = [])
    {
        $this->field = $field;
        $this->points = $points;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_polygon';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [$this->field => ['points' => $this->points]];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
