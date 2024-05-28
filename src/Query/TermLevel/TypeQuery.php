<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\TermLevel;

use Biano\ElasticsearchDSL\BuilderInterface;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-type-query.html
 */
class TypeQuery implements BuilderInterface
{

    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return 'type';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            $this->getType() => [
                'value' => $this->type,
            ],
        ];
    }

}
