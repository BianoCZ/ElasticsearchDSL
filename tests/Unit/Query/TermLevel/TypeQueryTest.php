<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\TypeQuery;
use PHPUnit\Framework\TestCase;

class TypeQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new TypeQuery('foo');

        $expected = [
            'type' => ['value' => 'foo'],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
