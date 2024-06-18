<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\Query\Span\SpanTermQuery;
use PHPUnit\Framework\TestCase;

class SpanTermQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new SpanTermQuery('user', 'bob');
        $expected = [
            'span_term' => ['user' => 'bob'],
        ];

        self::assertEquals($expected, $query->toArray());
    }

    public function testToArrayWithParameters(): void
    {
        $query = new SpanTermQuery('user', 'bob', ['boost' => 2]);
        $expected = [
            'span_term' => ['user' => ['value' => 'bob', 'boost' => 2]],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
