<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\Query\Span\SpanNearQuery;
use Biano\ElasticsearchDSL\Query\Span\SpanQueryInterface;
use PHPUnit\Framework\TestCase;

class SpanNearQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $mock = $this->createMock(SpanQueryInterface::class);
        $mock
            ->expects(self::once())
            ->method('toArray')
            ->willReturn(['span_term' => ['key' => 'value']]);

        $query = new SpanNearQuery(['in_order' => false]);
        $query->setSlop(5);
        $query->addQuery($mock);

        $result = $query->toArray();
        $expected = [
            'span_near' => [
                'clauses' => [
                    0 => [
                        'span_term' => ['key' => 'value'],
                    ],
                ],
                'slop' => 5,
                'in_order' => false,
            ],
        ];

        self::assertEquals($expected, $result);
    }

}
