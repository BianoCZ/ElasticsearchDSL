<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\InnerHit;

use Biano\ElasticsearchDSL\InnerHit\NestedInnerHit;
use Biano\ElasticsearchDSL\Query\FullText\MatchQuery;
use Biano\ElasticsearchDSL\Query\Joining\NestedQuery;
use Biano\ElasticsearchDSL\Search;
use PHPUnit\Framework\TestCase;
use stdClass;

class NestedInnerHitTest extends TestCase
{

    /**
     * Data provider for testToArray().
     */
    public function getTestToArrayData(): array
    {
        $out = [];

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

        $out[] = [
            $emptyInnerHit,
            [
                'path' => [
                    'foo' => new stdClass(),
                ],
            ],
        ];

        $out[] = [
            $nestedInnerHit1,
            [
                'path' => [
                    'foo.bar.aux' => [
                        'query' => $matchQuery->toArray(),
                    ],
                ],
            ],
        ];

        $out[] = [
            $innerHit,
            [
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

        return $out;
    }

    /**
     * Tests toArray() method.
     *
     * @dataProvider getTestToArrayData
     */
    public function testToArray(NestedInnerHit $innerHit, array $expected): void
    {
        $this->assertEquals($expected, $innerHit->toArray());
    }

    /**
     * Tests getters and setters for $name, $path and $query
     */
    public function testGettersAndSetters(): void
    {
        $query = new MatchQuery('acme', 'test');
        $search = new Search();
        $search->addQuery($query);

        $hit = new NestedInnerHit('test', 'acme', new Search());
        $hit->setName('foo');
        $hit->setPath('bar');
        $hit->setSearch($search);

        $this->assertEquals('foo', $hit->getName());
        $this->assertEquals('bar', $hit->getPath());
        $this->assertEquals($search, $hit->getSearch());
    }

}
