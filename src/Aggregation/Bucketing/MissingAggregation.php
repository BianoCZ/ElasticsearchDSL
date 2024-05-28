<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use LogicException;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-missing-aggregation.html
 */
class MissingAggregation extends AbstractBucketingAggregation
{

    public function __construct(string $name, ?string $field = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }
    }

    public function getType(): string
    {
        return 'missing';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getField() === null) {
            throw new LogicException('Missing aggregation must have a field set.');
        }

        return [
            'field' => $this->getField(),
        ];
    }

}
