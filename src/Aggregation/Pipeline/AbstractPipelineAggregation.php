<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;
use function array_filter;

abstract class AbstractPipelineAggregation extends AbstractAggregation
{

    /** @var array<string,string>|string|null */
    private string|array|null $bucketsPath = null;

    /**
     * @param array<string,string>|string|null $bucketsPath
     */
    public function __construct(string $name, string|array|null $bucketsPath = null)
    {
        parent::__construct($name);

        if ($bucketsPath !== null) {
            $this->setBucketsPath($bucketsPath);
        }
    }

    /**
     * Pipeline aggregations does not support nesting.
     */
    protected function supportsNesting(): bool
    {
        return false;
    }

    /**
     * @return  array<string,string>|string|null
     */
    public function getBucketsPath(): string|array|null
    {
        return $this->bucketsPath;
    }

    /**
     * @param array<string,string>|string $bucketsPath
     */
    public function setBucketsPath(string|array $bucketsPath): self
    {
        $this->bucketsPath = $bucketsPath;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter([
            'buckets_path' => $this->getBucketsPath(),
        ]);
    }

}
