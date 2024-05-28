<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\Query\TermLevel\TermQuery;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-term-query.html
 */
class SpanTermQuery extends TermQuery implements SpanQueryInterface
{

    public function getType(): string
    {
        return 'span_term';
    }

}
