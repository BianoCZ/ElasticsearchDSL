<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Pipeline;

use LogicException;
use function sprintf;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-pipeline-bucket-script-aggregation.html
 */
class BucketScriptAggregation extends AbstractPipelineAggregation
{

    private ?string $script = null;

    /**
     * @param array<string,string> $bucketsPath
     */
    public function __construct(string $name, array $bucketsPath, ?string $script = null)
    {
        parent::__construct($name, $bucketsPath);

        if ($script !== null) {
            $this->setScript($script);
        }
    }

    public function getScript(): ?string
    {
        return $this->script;
    }

    public function setScript(string $script): self
    {
        $this->script = $script;

        return $this;
    }

    public function getType(): string
    {
        return 'bucket_script';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getScript() === null) {
            throw new LogicException(sprintf('`%s` aggregation must have script set.', $this->getName()));
        }

        return [
            'buckets_path' => $this->getBucketsPath(),
            'script' => $this->getScript(),
        ];
    }

}
