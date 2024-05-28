<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use LogicException;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-geodistance-aggregation.html
 */
class GeoDistanceAggregation extends AbstractBucketingAggregation
{

    private mixed $origin = null;

    private ?string $distanceType = null;

    private ?string $unit = null;

    /** @var list<array<string,mixed>> */
    private array $ranges = [];

    /**
     * @param list<array<string,mixed>> $ranges
     */
    public function __construct(string $name, ?string $field = null, mixed $origin = null, array $ranges = [], ?string $unit = null, ?string $distanceType = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($origin !== null) {
            $this->setOrigin($origin);
        }

        foreach ($ranges as $range) {
            $this->addRange($range['from'] ?? null, $range['to'] ?? null);
        }

        if ($unit !== null) {
            $this->setUnit($unit);
        }

        if ($distanceType !== null) {
            $this->setDistanceType($distanceType);
        }
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(mixed $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getDistanceType(): ?string
    {
        return $this->distanceType;
    }

    public function setDistanceType(string $distanceType): self
    {
        $this->distanceType = $distanceType;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Add range to aggregation.
     *
     * @throws \LogicException
     */
    public function addRange(int|float|string|null $from = null, int|float|string|null $to = null): GeoDistanceAggregation
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
            ],
            static fn ($v): bool => $v !== null,
        );

        if (empty($range)) {
            throw new LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        $data = [];

        if (!$this->getField()) {
            throw new LogicException('Geo distance aggregation must have a field set.');
        }

        $data['field'] = $this->getField();

        if (!$this->getOrigin()) {
            throw new LogicException('Geo distance aggregation must have an origin set.');
        }

        $data['origin'] = $this->getOrigin();

        if ($this->getUnit()) {
            $data['unit'] = $this->getUnit();
        }

        if ($this->getDistanceType()) {
            $data['distance_type'] = $this->getDistanceType();
        }

        $data['ranges'] = $this->ranges;

        return $data;
    }

    public function getType(): string
    {
        return 'geo_distance';
    }

}
