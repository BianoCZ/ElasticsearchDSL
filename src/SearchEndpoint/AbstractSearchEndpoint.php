<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\SearchEndpoint;

use BadFunctionCallException;
use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;
use Biano\ElasticsearchDSL\Query\Compound\BoolQuery;
use Biano\ElasticsearchDSL\Serializer\Normalizer\AbstractNormalizable;
use OverflowException;
use function array_key_exists;
use function bin2hex;
use function random_bytes;
use function sprintf;

abstract class AbstractSearchEndpoint extends AbstractNormalizable implements SearchEndpointInterface
{

    use ParametersTrait;

    /** @var array<string,\Biano\ElasticsearchDSL\BuilderInterface> */
    private array $container = [];

    abstract protected function getName(): string;

    public function add(BuilderInterface $builder, ?string $key = null): string
    {
        if (array_key_exists((string) $key, $this->container)) {
            throw new OverflowException(sprintf('Builder with %s name for endpoint has already been added!', $key));
        }

        if ($key === null) {
            $key = bin2hex(random_bytes(30));
        }

        $this->container[$key] = $builder;

        return $key;
    }

    public function addToBool(BuilderInterface $builder, ?string $boolType = null, ?string $key = null): string
    {
        throw new BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::getName()));
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($this->container[$key]);
        }
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->container);
    }

    public function get(string $key): ?BuilderInterface
    {
        if ($this->has($key)) {
            return $this->container[$key];
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function getAll(?string $boolType = null): array
    {
        return $this->container;
    }

    public function getBool(): ?BoolQuery
    {
        throw new BadFunctionCallException(sprintf("Endpoint %s doesn't support bool statements", static::getName()));
    }

}
