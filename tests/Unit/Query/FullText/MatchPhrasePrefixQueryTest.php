<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\FullText;

use Biano\ElasticsearchDSL\Query\FullText\MatchPhrasePrefixQuery;
use PHPUnit\Framework\TestCase;

class MatchPhrasePrefixQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new MatchPhrasePrefixQuery('message', 'this is a test');
        $expected = [
            'match_phrase_prefix' => [
                'message' => ['query' => 'this is a test'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
