<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\ScriptAwareTrait;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-terms-aggregation.html
 */
class TermsAggregation extends AbstractBucketingAggregation
{

    use ScriptAwareTrait;

    public function __construct(string $name, ?string $field = null, ?string $script = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($script !== null) {
            $this->setScript($script);
        }
    }

    public function getType(): string
    {
        return 'terms';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
            ],
        );
    }

}
