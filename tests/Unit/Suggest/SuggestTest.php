<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Suggest;

use Biano\ElasticsearchDSL\Suggest\Suggest;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SuggestTest extends TestCase
{

    public function testSuggestGetType(): void
    {
        $suggest = new Suggest('foo', 'term', 'acme', 'bar');

        self::assertEquals('term', $suggest->getType());
    }

    /**
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(Suggest $suggest, array $expected): void
    {
        self::assertEquals($expected, $suggest->toArray());
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        yield [
            'suggest' => new Suggest(
                'foo',
                'term',
                'bar',
                'acme',
                ['size' => 5],
            ),
            'expected' => [
                'foo' => [
                    'text' => 'bar',
                    'term' => [
                        'field' => 'acme',
                        'size' => 5,
                    ],
                ],
            ],
        ];

        yield [
            'suggest' => new Suggest(
                'foo',
                'phrase',
                'bar',
                'acme',
                ['max_errors' => 0.5],
            ),
            'expected' => [
                'foo' => [
                    'text' => 'bar',
                    'phrase' => [
                        'field' => 'acme',
                        'max_errors' => 0.5,
                    ],
                ],
            ],
        ];

        yield [
            'suggest' => new Suggest(
                'foo',
                'completion',
                'bar',
                'acme',
                ['fuzziness' => 2],
            ),
            'expected' => [
                'foo' => [
                    'text' => 'bar',
                    'completion' => [
                        'field' => 'acme',
                        'fuzziness' => 2,
                    ],
                ],
            ],
        ];

        yield [
            'suggest' => new Suggest(
                'foo',
                'completion',
                'bar',
                'acme',
                ['context' => ['color' => 'red'], 'size' => 3],
            ),
            'expected' => [
                'foo' => [
                    'text' => 'bar',
                    'completion' => [
                        'field' => 'acme',
                        'size' => 3,
                        'context' => ['color' => 'red'],
                    ],
                ],
            ],
        ];
    }

}
