<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Suggest;

use Biano\ElasticsearchDSL\Suggest\Suggest;
use PHPUnit\Framework\TestCase;

class SuggestTest extends TestCase
{

    /**
     * Tests getType method.
     */
    public function testSuggestGetType(): void
    {
        $suggest = new Suggest('foo', 'term', 'acme', 'bar');
        $this->assertEquals('term', $suggest->getType());
    }

    /**
     * Data provider for testtoArray():array
     *
     * @return array[]
     */
    public function getTestToArrayData(): array
    {
        return [
            [
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
            ],
            [
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
            ],
            [
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
            ],
            [
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
            ],
        ];
    }

    /**
     * @dataProvider getTestToArrayData()
     */
    public function testToArray(Suggest $suggest, array $expected): void
    {
        $this->assertEquals($expected, $suggest->toArray());
    }

}
