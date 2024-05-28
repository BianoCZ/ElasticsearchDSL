<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\Query\Span\SpanTermQuery;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for SpanTermQuery.
 */
class SpanTermQueryTest extends TestCase
{

    /**
     * Tests for toArray().
     */
    public function testToArray(): void
    {
        $query = new SpanTermQuery('user', 'bob');
        $expected = [
            'span_term' => ['user' => 'bob'],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests for toArray() with parameters.
     */
    public function testToArrayWithParameters(): void
    {
        $query = new SpanTermQuery('user', 'bob', ['boost' => 2]);
        $expected = [
            'span_term' => ['user' => ['value' => 'bob', 'boost' => 2]],
        ];

        $this->assertEquals($expected, $query->toArray());
    }

}
