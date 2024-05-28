<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Compound;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\Query\Compound\FunctionScoreQuery;
use Biano\ElasticsearchDSL\Query\MatchAllQuery;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use function assert;

/**
 * Tests for FunctionScoreQuery.
 */
class FunctionScoreQueryTest extends TestCase
{

    /**
     * Data provider for testAddRandomFunction.
     */
    public function addRandomFunctionProvider(): array
    {
        return [
            // Case #0. No seed.
            [
                'seed' => null,
                'expectedArray' => [
                    'query' => [],
                    'functions' => [
                        [
                            'random_score' => new stdClass(),
                        ],
                    ],
                ],
            ],
            // Case #1. With seed.
            [
                'seed' => 'someSeed',
                'expectedArray' => [
                    'query' => [],
                    'functions' => [
                        [
                            'random_score' => [ 'seed' => 'someSeed'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Tests addRandomFunction method.
     *
     * @dataProvider addRandomFunctionProvider
     */
    public function testAddRandomFunction(mixed $seed, array $expectedArray): void
    {
        $matchAllQuery = $this->getMockBuilder(MatchAllQuery::class)->getMock();
        assert($matchAllQuery instanceof MatchAllQuery || $matchAllQuery instanceof MockObject);

        $functionScoreQuery = new FunctionScoreQuery($matchAllQuery);
        $functionScoreQuery->addRandomFunction($seed);

        $this->assertEquals(['function_score' => $expectedArray], $functionScoreQuery->toArray());
    }

    /**
     * Tests default argument values.
     */
    public function testAddFieldValueFactorFunction(): void
    {
        $builderInterface = $this->getMockForAbstractClass(BuilderInterface::class);
        assert($builderInterface instanceof BuilderInterface || $builderInterface instanceof MockObject);
        $functionScoreQuery = new FunctionScoreQuery($builderInterface);
        $functionScoreQuery->addFieldValueFactorFunction('field1', 2);
        $functionScoreQuery->addFieldValueFactorFunction('field2', 1.5, 'ln');

        $this->assertEquals(
            [
                'query' => [],
                'functions' => [
                    [
                        'field_value_factor' => [
                            'field' => 'field1',
                            'factor' => 2,
                            'modifier' => 'none',
                        ],
                    ],
                    [
                        'field_value_factor' => [
                            'field' => 'field2',
                            'factor' => 1.5,
                            'modifier' => 'ln',
                        ],
                    ],
                ],
            ],
            $functionScoreQuery->toArray()['function_score'],
        );
    }

}
