<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\TermLevel;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-terms-query.html
 */
class TermsQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $field;

    /** @var list<string|int|float|bool>|string|int|float|bool */
    private string|int|float|bool|array $terms;

    /**
     * @param list<string|int|float|bool>|string|int|float|bool $terms
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $field, string|int|float|bool|array $terms, array $parameters = [])
    {
        $this->field = $field;
        $this->terms = $terms;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'terms';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            $this->field => $this->terms,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
