<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\IdsQuery;
use PHPUnit\Framework\TestCase;

class IdsQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new IdsQuery(['foo', 'bar']);
        $expected = [
            'ids' => [
                'values' => ['foo', 'bar'],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
