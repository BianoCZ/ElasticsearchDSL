<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Sort;

use Biano\ElasticsearchDSL\Query\TermLevel\TermQuery;
use Biano\ElasticsearchDSL\Sort\NestedSort;
use PHPUnit\Framework\TestCase;

class NestedSortTest extends TestCase
{

    /**
     * Test for single nested.
     */
    public function testSingle(): void
    {
        $query = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $expected = [
            'path'   => 'somePath',
            'filter' => [
                'term' => ['somePath.id' => 10],
            ],
        ];
        $result = $query->toArray();
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for single nested, no filter.
     */
    public function testNoFilter(): void
    {
        $query = new NestedSort('somePath');
        $expected = ['path' => 'somePath'];
        $result = $query->toArray();
        $this->assertEquals($expected, $result);
    }

    /**
     * Test for single nested.
     */
    public function testMultipleNesting(): void
    {
        $query = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $nestedFilter1 = new NestedSort('secondPath', new TermQuery('secondPath.foo', 'bar'));
        $nestedFilter2 = new NestedSort('thirdPath', new TermQuery('thirdPath.x', 'y'));
        $nestedFilter1->setNestedFilter($nestedFilter2);
        $query->setNestedFilter($nestedFilter1);
        $expected = [
            'path'   => 'somePath',
            'filter' => [
                'term' => ['somePath.id' => 10],
            ],
            'nested' => [
                'path'   => 'secondPath',
                'filter' => [
                    'term' => ['secondPath.foo' => 'bar'],
                ],
                'nested' => [
                    'path'   => 'thirdPath',
                    'filter' => [
                        'term' => ['thirdPath.x' => 'y'],
                    ],
                ],
            ],
        ];
        $result = $query->toArray();
        $this->assertEquals($expected, $result);
    }

}
