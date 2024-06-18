<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Sort;

use Biano\ElasticsearchDSL\Query\TermLevel\TermQuery;
use Biano\ElasticsearchDSL\Sort\FieldSort;
use Biano\ElasticsearchDSL\Sort\NestedSort;
use PHPUnit\Framework\TestCase;

class FieldSortTest extends TestCase
{

    public function testToArray(): void
    {
        $nestedFilter = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $sort = new FieldSort('someField', 'asc');
        $sort->setNestedFilter($nestedFilter);

        $result = $sort->toArray();
        $expected = [
            'someField' => [
                'nested' => [
                    'path'   => 'somePath',
                    'filter' => [
                        'term' => ['somePath.id' => 10],
                    ],
                ],
                'order'  => 'asc',
            ],
        ];

        self::assertEquals($expected, $result);
    }

}
