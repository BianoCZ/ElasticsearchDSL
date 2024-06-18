<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\GlobalAggregation;
use LogicException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use function json_encode;

class GlobalAggregationTest extends TestCase
{

    /**
     * @param array<string,mixed> $expected
     */
    #[DataProvider('provideToArray')]
    public function testToArray(GlobalAggregation $aggregation, array $expected): void
    {
        self::assertEquals(
            json_encode($expected),
            json_encode($aggregation->toArray()),
        );
    }

    /**
     * @return iterable<array<string,mixed>>
     */
    public static function provideToArray(): iterable
    {
        // Case #0 global aggregation.
        $aggregation = new GlobalAggregation('test_agg');

        $expected = [
            'global' => new stdClass(),
        ];

        yield [
            'aggregation' => $aggregation,
            'expected' => $expected,
        ];

        // Case #1 nested global aggregation.
        $aggregation = new GlobalAggregation('test_agg');
        $aggregation2 = new GlobalAggregation('test_agg_2');
        $aggregation->addAggregation($aggregation2);

        $expected = [
            'global' => new stdClass(),
            'aggregations' => [
                $aggregation2->getName() => $aggregation2->toArray(),
            ],
        ];

        yield [
            'aggregation' => $aggregation,
            'expected' => $expected,
        ];
    }

    /**
     * Test for setField method on global aggregation.
     */
    public function testSetField(): void
    {
        $this->expectException(LogicException::class);

        $aggregation = new GlobalAggregation('test_agg');
        $aggregation->setField('test_field');
    }

}
