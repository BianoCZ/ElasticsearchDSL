<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\WildcardQuery;
use PHPUnit\Framework\TestCase;

class WildcardQueryTest extends TestCase
{

    /**
     * Test for query toArray() method.
     */
    public function testToArray(): void
    {
        $query = new WildcardQuery('user', 'ki*y');
        $expectedResult = [
            'wildcard' => [
                'user' => ['value' => 'ki*y'],
            ],
        ];

        $this->assertEquals($expectedResult, $query->toArray());
    }

}
