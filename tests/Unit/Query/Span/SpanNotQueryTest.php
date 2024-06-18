<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\Query\Span\SpanNotQuery;
use Biano\ElasticsearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\TestCase;

class SpanNotQueryTest extends TestCase
{

    public function testSpanNotQueryToArray(): void
    {
        $mock = $this->createMock(SpanQueryInterface::class);
        $mock
            ->expects($this->exactly(2))
            ->method('toArray')
            ->willReturn(['span_term' => ['key' => 'value']]);

        $query = new SpanNotQuery($mock, $mock);

        $result = $query->toArray();
        $expected = [
            'span_not' => [
                'include' => [
                    'span_term' => ['key' => 'value'],
                ],
                'exclude' => [
                    'span_term' => ['key' => 'value'],
                ],
            ],
        ];

        self::assertEquals($expected, $result);
    }

}
