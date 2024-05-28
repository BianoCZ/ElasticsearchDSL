<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Geo;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;
use LogicException;
use function count;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-bounding-box-query.html
 */
class GeoBoundingBoxQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    /** @var array<mixed> */
    private array $values;

    /**
     * @param array<mixed> $values
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, array $values, array $parameters = [])
    {
        $this->field = $field;
        $this->values = $values;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'geo_bounding_box';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            $this->getType() => $this->processArray([$this->field => $this->points()]),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    private function points(): array
    {
        if (count($this->values) === 2) {
            return [
                'top_left' => $this->values[0] ?? $this->values['top_left'],
                'bottom_right' => $this->values[1] ?? $this->values['bottom_right'],
            ];
        }

        if (count($this->values) === 4) {
            return [
                'top' => $this->values[0] ?? $this->values['top'],
                'left' => $this->values[1] ?? $this->values['left'],
                'bottom' => $this->values[2] ?? $this->values['bottom'],
                'right' => $this->values[3] ?? $this->values['right'],
            ];
        }

        throw new LogicException('Geo Bounding Box filter must have 2 or 4 geo points set.');
    }

}
