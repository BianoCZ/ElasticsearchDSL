<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\FullText;

use Biano\ElasticsearchDSL\Query\FullText\MatchPhraseQuery;
use PHPUnit\Framework\TestCase;

class MatchPhraseQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new MatchPhraseQuery('message', 'this is a test');
        $expected = [
            'match_phrase' => [
                'message' => ['query' => 'this is a test'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
