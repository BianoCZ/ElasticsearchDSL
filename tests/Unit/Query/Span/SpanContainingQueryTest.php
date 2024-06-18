<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\Query\Span\SpanContainingQuery;
use Biano\ElasticsearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SpanContainingQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new SpanContainingQuery(
            $this->getSpanQueryMock('foo'),
            $this->getSpanQueryMock('bar'),
        );

        $result = $query->toArray();
        $expected = [
            'span_containing' => [
                'little' => [
                    'span_term' => ['user' => 'foo'],
                ],
                'big' => [
                    'span_term' => ['user' => 'bar'],
                ],
            ],
        ];

        self::assertEquals($expected, $result);
    }

    private function getSpanQueryMock(string $value): SpanQueryInterface&MockObject
    {
        $mock = $this->createMock(SpanQueryInterface::class);
        $mock->expects(self::once())->method('toArray')->willReturn(['span_term' => ['user' => $value]]);

        return $mock;
    }

}
