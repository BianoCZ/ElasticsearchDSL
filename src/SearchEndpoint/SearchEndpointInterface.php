<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\SearchEndpoint;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\Query\Compound\BoolQuery;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

interface SearchEndpointInterface extends NormalizableInterface
{

    /**
     * Adds builder to search endpoint.
     * Returns key of added builder.
     */
    public function add(BuilderInterface $builder, ?string $key = null): string;

    /**
     * Adds builder to search endpoint's specific bool type container.
     * Returns key of added builder.
     */
    public function addToBool(BuilderInterface $builder, ?string $boolType = null, ?string $key = null): string;

    /**
     * Removes contained builder.
     */
    public function remove(string $key): void;

    /**
     * Returns contained builder or null if Builder is not found.
     */
    public function get(string $key): ?BuilderInterface;

    /**
     * Returns contained builder or null if Builder is not found.
     *
     * @return array<string,\Biano\ElasticsearchDSL\BuilderInterface>
     */
    public function getAll(?string $boolType = null): array;

    /**
     * Returns Bool filter or query instance with all builder objects inside.
     */
    public function getBool(): ?BoolQuery;

}
