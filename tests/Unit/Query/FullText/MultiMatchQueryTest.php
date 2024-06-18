<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\FullText;

use Biano\ElasticsearchDSL\Query\FullText\MultiMatchQuery;
use PHPUnit\Framework\TestCase;

class MultiMatchQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new MultiMatchQuery(['message', 'title'], 'this is a test');
        $expected = [
            'multi_match' => [
                'query' => 'this is a test',
                'fields' => ['message', 'title'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

    public function testToArrayWithNoFields(): void
    {
        $query = new MultiMatchQuery([], 'this is a test');
        $expected = [
            'multi_match' => ['query' => 'this is a test'],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
