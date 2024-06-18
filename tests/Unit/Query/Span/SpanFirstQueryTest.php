<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\Query\Span\SpanFirstQuery;
use Biano\ElasticsearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\TestCase;

class SpanFirstQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $mock = $this->createMock(SpanQueryInterface::class);
        $mock
            ->expects(self::once())
            ->method('toArray')
            ->willReturn(['span_term' => ['user' => 'bob']]);

        $query = new SpanFirstQuery($mock, 5);

        $result = $query->toArray();
        $expected = [
            'span_first' => [
                'match' => [
                    'span_term' => ['user' => 'bob'],
                ],
                'end' => 5,
            ],
        ];

        self::assertEquals($expected, $result);
    }

}
