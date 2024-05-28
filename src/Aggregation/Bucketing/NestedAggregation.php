<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-nested-aggregation.html
 */
class NestedAggregation extends AbstractBucketingAggregation
{

    private ?string $path = null;

    public function __construct(string $name, ?string $path = null)
    {
        parent::__construct($name);

        if ($path !== null) {
            $this->setPath($path);
        }
    }

    /**
     * Return path.
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getType(): string
    {
        return 'nested';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return [
            'path' => $this->getPath(),
        ];
    }

}
