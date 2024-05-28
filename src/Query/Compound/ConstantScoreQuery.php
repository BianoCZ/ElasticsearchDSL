<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Compound;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-constant-score-query.html
 */
class ConstantScoreQuery implements BuilderInterface
{

    use ParametersTrait;

    private BuilderInterface $query;

    /**
     * @param array<mixed> $parameters
     */
    public function __construct(BuilderInterface $query, array $parameters = [])
    {
        $this->query = $query;
        $this->setParameters($parameters);
    }

    public function getQuery(): BuilderInterface
    {
        return $this->query;
    }

    public function getType(): string
    {
        return 'constant_score';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'filter' => $this->getQuery()->toArray(),
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
