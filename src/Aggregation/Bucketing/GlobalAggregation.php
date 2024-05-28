<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use LogicException;
use stdClass;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-global-aggregation.html
 */
class GlobalAggregation extends AbstractBucketingAggregation
{

    public function setField(string $field): self
    {
        throw new LogicException("Global aggregation doesn't support `field` parameter");
    }

    public function getType(): string
    {
        return 'global';
    }

    public function getArray(): stdClass
    {
        return new stdClass();
    }

}
