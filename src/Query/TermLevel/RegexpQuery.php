<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\TermLevel;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-regexp-query.html
 */
class RegexpQuery implements BuilderInterface
{

    use ParametersTrait;

    /**
     * Field to be queried.
     */
    private string $field;

    /**
     * The actual regexp value to be used.
     */
    private string $regexpValue;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, string $regexpValue, array $parameters = [])
    {
        $this->field = $field;
        $this->regexpValue = $regexpValue;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'regexp';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'value' => $this->regexpValue,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }

}
