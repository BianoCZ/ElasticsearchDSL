<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Compound;

use Biano\ElasticsearchDSL\BuilderInterface;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-boosting-query.html
 */
class BoostingQuery implements BuilderInterface
{

    private BuilderInterface $positive;

    private BuilderInterface $negative;

    private int|float $negativeBoost;

    public function __construct(BuilderInterface $positive, BuilderInterface $negative, int|float $negativeBoost)
    {
        $this->positive = $positive;
        $this->negative = $negative;
        $this->negativeBoost = $negativeBoost;
    }

    public function getType(): string
    {
        return 'boosting';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'positive' => $this->positive->toArray(),
            'negative' => $this->negative->toArray(),
            'negative_boost' => $this->negativeBoost,
        ];

        return [$this->getType() => $query];
    }

}
