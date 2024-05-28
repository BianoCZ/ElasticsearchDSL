<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Specialized;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-script-query.html
 */
class ScriptQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $script;

    /**
     * @param array<mixed> $parameters
     */
    public function __construct(string $script, array $parameters = [])
    {
        $this->script = $script;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'script';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = ['inline' => $this->script];
        $output = $this->processArray($query);

        return [$this->getType() => ['script' => $output]];
    }

}
