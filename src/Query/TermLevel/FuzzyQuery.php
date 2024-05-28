<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\TermLevel;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-fuzzy-query.html
 */
class FuzzyQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    private string $value;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, string $value, array $parameters = [])
    {
        $this->field = $field;
        $this->value = $value;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'fuzzy';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'value' => $this->value,
        ];

        $output = [
            $this->field => $this->processArray($query),
        ];

        return [$this->getType() => $output];
    }

}
