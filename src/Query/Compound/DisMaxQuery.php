<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Compound;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-dis-max-query.html
 */
class DisMaxQuery implements BuilderInterface
{

    use ParametersTrait;

    /** @var list<\Biano\ElasticsearchDSL\BuilderInterface> */
    private array $queries = [];

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * Add query.
     */
    public function addQuery(BuilderInterface $query): self
    {
        $this->queries[] = $query;

        return $this;
    }

    public function getType(): string
    {
        return 'dis_max';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [];
        foreach ($this->queries as $type) {
            $query[] = $type->toArray();
        }

        $output = $this->processArray(['queries' => $query]);

        return [$this->getType() => $output];
    }

}
