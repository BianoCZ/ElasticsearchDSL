<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\PrefixQuery;
use PHPUnit\Framework\TestCase;

class PrefixQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new PrefixQuery('user', 'ki');
        $expected = [
            'prefix' => [
                'user' => ['value' => 'ki'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
