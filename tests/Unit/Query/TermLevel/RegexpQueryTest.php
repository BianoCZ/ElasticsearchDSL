<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\RegexpQuery;
use PHPUnit\Framework\TestCase;

class RegexpQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new RegexpQuery('user', 's.*y');
        $expected = [
            'regexp' => [
                'user' => ['value' => 's.*y'],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
