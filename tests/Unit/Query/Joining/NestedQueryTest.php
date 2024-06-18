<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Joining;

use Biano\ElasticsearchDSL\Query\Joining\NestedQuery;
use Biano\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NestedQueryTest extends TestCase
{

    /**
     * @param array<string,mixed> $parameters
     * @param array<string,mixed> $expected
     */
     #[DataProvider('provideToArray')]
    public function testToArray(string $path, array $parameters, array $expected): void
    {
        $query = new TermsQuery('foo', 'bar');
        $query = new NestedQuery($path, $query, $parameters);

        $result = $query->toArray();

        self::assertEquals(['nested' => $expected], $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        $query = [
            'terms' => ['foo' => 'bar'],
        ];

        yield 'query_only' => [
            'path' => 'product.sub_item',
            'parameters' => [],
            'expected' => ['path' => 'product.sub_item', 'query' => $query],
        ];

        yield 'query_with_parameters' => [
            'path' => 'product.sub_item',
            'parameters' => ['_cache' => true, '_name' => 'named_result'],
            'expected' => [
                'path' => 'product.sub_item',
                'query' => $query,
                '_cache' => true,
                '_name' => 'named_result',
            ],
        ];
    }

}
