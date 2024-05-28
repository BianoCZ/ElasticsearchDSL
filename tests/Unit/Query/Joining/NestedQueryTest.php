<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Joining;

use Biano\ElasticsearchDSL\Query\Joining\NestedQuery;
use Biano\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use PHPUnit\Framework\TestCase;

class NestedQueryTest extends TestCase
{

    /**
     * Data provider to testGetToArray.
     */
    public function getArrayDataProvider(): array
    {
        $query = [
            'terms' => ['foo' => 'bar'],
        ];

        return [
            'query_only' => [
                'product.sub_item',
                [],
                ['path' => 'product.sub_item', 'query' => $query],
            ],
            'query_with_parameters' => [
                'product.sub_item',
                ['_cache' => true, '_name' => 'named_result'],
                [
                    'path' => 'product.sub_item',
                    'query' => $query,
                    '_cache' => true,
                    '_name' => 'named_result',
                ],
            ],
        ];
    }

    /**
     * Test for query toArray() method.
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray(string $path, array $parameters, array $expected): void
    {
        $query = new TermsQuery('foo', 'bar');
        $query = new NestedQuery($path, $query, $parameters);
        $result = $query->toArray();
        $this->assertEquals(['nested' => $expected], $result);
    }

}
