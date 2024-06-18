<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\InnerHit;

use Biano\ElasticsearchDSL\InnerHit\ParentInnerHit;
use Biano\ElasticsearchDSL\Query\TermLevel\TermQuery;
use Biano\ElasticsearchDSL\Search;
use PHPUnit\Framework\TestCase;

class ParentInnerHitTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new TermQuery('foo', 'bar');
        $search = new Search();
        $search->addQuery($query);

        $hit = new ParentInnerHit('test', 'acme', $search);
        $expected = [
            'type' => [
                'acme' => [
                    'query' => $query->toArray(),
                ],
            ],
        ];

        self::assertEquals($expected, $hit->toArray());
    }

}
