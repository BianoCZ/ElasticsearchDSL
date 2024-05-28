<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\FullText;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
 */
class MatchPhraseQuery extends MatchQuery
{

    public function getType(): string
    {
        return 'match_phrase';
    }

}
