<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\RegexpQuery;
use PHPUnit\Framework\TestCase;

class RegexpQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new RegexpQuery('user', 's.*y');
        $expected = [
            'regexp' => [
                'user' => ['value' => 's.*y'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
