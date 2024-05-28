<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use PHPUnit\Framework\TestCase;

class RangeQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new RangeQuery('age', ['gte' => 10, 'lte' => 20]);
        $expected = [
            'range' => [
                'age' => [
                    'gte' => 10,
                    'lte' => 20,
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
