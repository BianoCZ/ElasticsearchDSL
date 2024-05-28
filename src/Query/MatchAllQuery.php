<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;
use stdClass;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-all-query.html
 */
class MatchAllQuery implements BuilderInterface
{

    use ParametersTrait;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'match_all';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $params = $this->getParameters();

        return [$this->getType() => !empty($params) ? $params : new stdClass()];
    }

}
