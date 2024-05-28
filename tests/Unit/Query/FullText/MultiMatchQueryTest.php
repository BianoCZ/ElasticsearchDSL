<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\FullText;

use Biano\ElasticsearchDSL\Query\FullText\MultiMatchQuery;
use PHPUnit\Framework\TestCase;

class MultiMatchQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new MultiMatchQuery(['message', 'title'], 'this is a test');
        $expected = [
            'multi_match' => [
                'query' => 'this is a test',
                'fields' => ['message', 'title'],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests multi-match query with no fields.
     */
    public function testToArrayWithNoFields(): void
    {
        $query = new MultiMatchQuery([], 'this is a test');
        $expected = [
            'multi_match' => ['query' => 'this is a test'],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
