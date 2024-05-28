<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Specialized;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-mlt-query.html
 */
class MoreLikeThisQuery implements BuilderInterface
{

    use ParametersTrait;

    /**
     * The text to find documents like it, required if ids or docs are not specified.
     */
    private string $like;

    /**
     * @param array<string,mixed> $parameters
     */
    public function __construct(string $like, array $parameters = [])
    {
        $this->like = $like;
        $this->setParameters($parameters);
    }

    public function getType(): string
    {
        return 'more_like_this';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $query = [];

        if (($this->hasParameter('ids') === false) || ($this->hasParameter('docs') === false)) {
            $query['like'] = $this->like;
        }

        $output = $this->processArray($query);

        return [$this->getType() => $output];
    }

}
