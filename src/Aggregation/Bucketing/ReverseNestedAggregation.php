<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use stdClass;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-reverse-nested-aggregation.html
 */
class ReverseNestedAggregation extends AbstractBucketingAggregation
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
        return 'reverse_nested';
    }

    public function getArray(): array|stdClass
    {
        if ($this->getPath() === null) {
            return new stdClass();
        }

        return [
            'path' => $this->getPath(),
        ];
    }

}
