<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\WildcardQuery;
use PHPUnit\Framework\TestCase;

class WildcardQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new WildcardQuery('user', 'ki*y');

        $expected = [
            'wildcard' => [
                'user' => ['value' => 'ki*y'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
