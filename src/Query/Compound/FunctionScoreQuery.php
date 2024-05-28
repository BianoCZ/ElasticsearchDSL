<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Compound;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;
use stdClass;
use function array_filter;
use function array_merge;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-function-score-query.html
 */
class FunctionScoreQuery implements BuilderInterface
{

    use ParametersTrait;

    private BuilderInterface $query;

    /** @var array<mixed> */
    private array $functions;

    /**
     * @param array<string,mixed> $parameters
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

    /**
     * Creates field_value_factor function.
     */
    public function addFieldValueFactorFunction(string $field, float $factor, string $modifier = 'none', ?BuilderInterface $query = null, mixed $missing = null): self
    {
        $function = [
            'field_value_factor' => array_filter([
                'field' => $field,
                'factor' => $factor,
                'modifier' => $modifier,
                'missing' => $missing,
            ]),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Modifier to apply filter to the function score function.
     *
     * @param array<mixed> $function
     */
    private function applyFilter(array &$function, ?BuilderInterface $query = null): void
    {
        if (!$query) {
            return;
        }

        $function['filter'] = $query->toArray();
    }

    /**
     * Add decay function to function score. Weight and query are optional.
     *
     * @param array<mixed> $function
     * @param array<mixed> $options
     */
    public function addDecayFunction(string $type, string $field, array $function, array $options = [], ?BuilderInterface $query = null, ?int $weight = null): self
    {
        $function = array_filter(
            [
                $type => array_merge(
                    [$field => $function],
                    $options,
                ),
                'weight' => $weight,
            ],
        );

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds function to function score without decay function. Influence search score only for specific query.
     *
     * @return $this
     */
    public function addWeightFunction(float $weight, ?BuilderInterface $query = null)
    {
        $function = ['weight' => $weight];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds random score function. Seed is optional.
     *
     * @return $this
     */
    public function addRandomFunction(mixed $seed = null, ?BuilderInterface $query = null)
    {
        $function = [
            'random_score' => $seed ? ['seed' => $seed] : new stdClass(),
        ];

        $this->applyFilter($function, $query);

        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds script score function.
     *
     * @param array<mixed> $params
     * @param array<mixed> $options
     */
    public function addScriptScoreFunction(string $source, array $params = [], array $options = [], ?BuilderInterface $query = null): self
    {
        $function = [
            'script_score' => [
                'script' => array_filter(array_merge([
                    'lang' => 'painless',
                    'source' => $source,
                    'params' => $params,
                ], $options,)),
            ],
        ];

        $this->applyFilter($function, $query);
        $this->functions[] = $function;

        return $this;
    }

    /**
     * Adds custom simple function. You can add to the array whatever you want.
     *
     * @param array<mixed> $function
     */
    public function addSimpleFunction(array $function): self
    {
        $this->functions[] = $function;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'query' => $this->query->toArray(),
            'functions' => $this->functions,
        ];

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

    public function getType(): string
    {
        return 'function_score';
    }

}
