<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\TermLevel;

use Biano\ElasticsearchDSL\BuilderInterface;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-exists-query.html
 */
class ExistsQuery implements BuilderInterface
{

    private string $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public function getType(): string
    {
        return 'exists';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            $this->getType() => [
                'field' => $this->field,
            ],
        ];
    }

}
