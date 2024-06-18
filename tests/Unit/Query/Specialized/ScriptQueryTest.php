<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use Biano\ElasticsearchDSL\Query\Specialized\ScriptQuery;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ScriptQueryTest extends TestCase
{

    /**
     * Test for toArray().
     *
     * @param array<string,mixed> $parameters
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(string $script, array $parameters, array $expected): void
    {
        $filter = new ScriptQuery($script, $parameters);

        $result = $filter->toArray();

        self::assertEquals(['script' => $expected], $result);
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        yield 'simple_script' => [
            'script' => "doc['num1'].value > 1",
            'parameters' => [],
            'expected' => ['script' => ['inline' => "doc['num1'].value > 1"]],
        ];

        yield 'script_with_parameters' => [
            'script' => "doc['num1'].value > param1",
            'parameters' => ['params' => ['param1' => 5]],
            'expected' => ['script' => ['inline' => "doc['num1'].value > param1", 'params' => ['param1' => 5]]],
        ];
    }

}
