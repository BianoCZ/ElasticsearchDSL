<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL;

use function array_merge;

/**
 * A trait which handles the behavior of parameters in queries, filters, etc.
 */
trait ParametersTrait
{

    /** @var array<string,mixed> */
    private array $parameters = [];

    /**
     * Returns one parameter by its name.
     */
    public function getParameter(string $name): mixed
    {
        return $this->parameters[$name];
    }

    /**
     * @return array<string,mixed>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function hasParameter(string $name): bool
    {
        return isset($this->parameters[$name]);
    }

    /**
     * @param array<string,mixed> $parameters
     */
    public function setParameters(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function addParameter(string $name, mixed $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    public function removeParameter(string $name): self
    {
        if ($this->hasParameter($name)) {
            unset($this->parameters[$name]);
        }

        return $this;
    }

    /**
     * Returns given array merged with parameters.
     *
     * @param array<mixed> $data
     *
     * @return array<mixed>
     */
    protected function processArray(array $data = []): array
    {
        return array_merge($data, $this->parameters);
    }

}
