<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\FullText;

use Biano\ElasticsearchDSL\Query\FullText\SimpleQueryStringQuery;
use PHPUnit\Framework\TestCase;

class SimpleQueryStringQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new SimpleQueryStringQuery('"fried eggs" +(eggplant | potato) -frittata');
        $expected = [
            'simple_query_string' => ['query' => '"fried eggs" +(eggplant | potato) -frittata'],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
