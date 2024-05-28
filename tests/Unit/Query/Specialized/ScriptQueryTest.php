<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use Biano\ElasticsearchDSL\Query\Specialized\ScriptQuery;
use PHPUnit\Framework\TestCase;

class ScriptQueryTest extends TestCase
{

    /**
     * Data provider for testToArray().
     */
    public function getArrayDataProvider(): array
    {
        return [
            'simple_script' => [
                "doc['num1'].value > 1",
                [],
                ['script' => ['inline' => "doc['num1'].value > 1"]],
            ],
            'script_with_parameters' => [
                "doc['num1'].value > param1",
                ['params' => ['param1' => 5]],
                ['script' => ['inline' => "doc['num1'].value > param1", 'params' => ['param1' => 5]]],
            ],
        ];
    }

    /**
     * Test for toArray().
     *
     * @param string $script     Script
     * @param array  $parameters Optional parameters
     * @param array  $expected   Expected values
     *
     * @dataProvider getArrayDataProvider
     */
    public function testToArray(string $script, array $parameters, array $expected): void
    {
        $filter = new ScriptQuery($script, $parameters);
        $result = $filter->toArray();
        $this->assertEquals(['script' => $expected], $result);
    }

}
