<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Span;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\Query\Span\SpanMultiTermQuery;
use PHPUnit\Framework\TestCase;

class SpanMultiTermQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $mock = $this->createMock(BuilderInterface::class);
        $mock
            ->expects(self::once())
            ->method('toArray')
            ->willReturn(['prefix' => ['user' => ['value' => 'ki']]]);

        $query = new SpanMultiTermQuery($mock);
        $expected = [
            'span_multi' => [
                'match' => [
                    'prefix' => ['user' => ['value' => 'ki']],
                ],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
