<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-within-query.html
 */
class SpanWithinQuery extends SpanContainingQuery
{

    public function getType(): string
    {
        return 'span_within';
    }

}
