<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\InnerHit;

use Biano\ElasticsearchDSL\InnerHit\NestedInnerHit;
use Biano\ElasticsearchDSL\Query\FullText\MatchQuery;
use Biano\ElasticsearchDSL\Query\Joining\NestedQuery;
use Biano\ElasticsearchDSL\Search;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

class NestedInnerHitTest extends TestCase
{

    /**
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(NestedInnerHit $innerHit, array $expected): void
    {
        self::assertEquals($expected, $innerHit->toArray());
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        $matchQuery = new MatchQuery('foo.bar.aux', 'foo');
        $nestedQuery = new NestedQuery('foo.bar', $matchQuery);
        $searchQuery = new Search();
        $searchQuery->addQuery($nestedQuery);

        $matchSearch = new Search();
        $matchSearch->addQuery($matchQuery);

        $innerHit = new NestedInnerHit('acme', 'foo', $searchQuery);
        $emptyInnerHit = new NestedInnerHit('acme', 'foo');

        $nestedInnerHit1 = new NestedInnerHit('aux', 'foo.bar.aux', $matchSearch);
        $nestedInnerHit2 = new NestedInnerHit('lux', 'foo.bar.aux', $matchSearch);
        $searchQuery->addInnerHit($nestedInnerHit1);
        $searchQuery->addInnerHit($nestedInnerHit2);

        yield [
            'innerHit' => $emptyInnerHit,
            'expected' => [
                'path' => [
                    'foo' => new stdClass(),
                ],
            ],
        ];

        yield [
            'innerHit' => $nestedInnerHit1,
            'expected' => [
                'path' => [
                    'foo.bar.aux' => [
                        'query' => $matchQuery->toArray(),
                    ],
                ],
            ],
        ];

        yield [
            'innerHit' => $innerHit,
            'expected' => [
                'path' => [
                    'foo' => [
                        'query' => $nestedQuery->toArray(),
                        'inner_hits' => [
                            'aux' => [
                                'path' => [
                                    'foo.bar.aux' => [
                                        'query' => $matchQuery->toArray(),
                                    ],
                                ],
                            ],
                            'lux' => [
                                'path' => [
                                    'foo.bar.aux' => [
                                        'query' => $matchQuery->toArray(),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function testGettersAndSetters(): void
    {
        $query = new MatchQuery('acme', 'test');
        $search = new Search();
        $search->addQuery($query);

        $hit = new NestedInnerHit('test', 'acme', new Search());
        $hit->setName('foo');
        $hit->setPath('bar');
        $hit->setSearch($search);

        self::assertEquals('foo', $hit->getName());
        self::assertEquals('bar', $hit->getPath());
        self::assertEquals($search, $hit->getSearch());
    }

}
