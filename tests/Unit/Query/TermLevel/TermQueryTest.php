<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\TermQuery;
use PHPUnit\Framework\TestCase;

class TermQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new TermQuery('user', 'bob');
        $expected = [
            'term' => ['user' => 'bob'],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
