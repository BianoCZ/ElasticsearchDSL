<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Joining;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-parent-id-query.html
 */
class ParentIdQuery implements BuilderInterface
{

    use ParametersTrait;

    private string $parentId;

    private string $childType;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $parentId, string $childType, array $parameters = [])
    {
        $this->childType = $childType;
        $this->parentId = $parentId;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'parent_id';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [
            'id' => $this->parentId,
            'type' => $this->childType,
        ];
        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
