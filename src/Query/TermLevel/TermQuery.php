<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\TermLevel;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-term-query.html
 */
class TermQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    private string|int|float|bool $value;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, string|int|float|bool $value, array $parameters = [])
    {
        $this->field = $field;
        $this->value = $value;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'term';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = $this->processArray();

        if (empty($query)) {
            $query = $this->value;
        } else {
            $query['value'] = $this->value;
        }

        $output = [$this->field => $query];

        return [$this->getType() => $output];
    }

}
