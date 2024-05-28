<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use Biano\ElasticsearchDSL\Query\Specialized\MoreLikeThisQuery;
use PHPUnit\Framework\TestCase;

class MoreLikeThisQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new MoreLikeThisQuery('this is a test', ['fields' => ['title', 'description']]);
        $expected = [
            'more_like_this' => [
                'fields' => ['title', 'description'],
                'like' => 'this is a test',
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
