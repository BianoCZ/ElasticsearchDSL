<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\FullText;

use Biano\ElasticsearchDSL\Query\FullText\QueryStringQuery;
use PHPUnit\Framework\TestCase;

class QueryStringQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new QueryStringQuery('this AND that OR thus');
        $expected = [
            'query_string' => ['query' => 'this AND that OR thus'],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
