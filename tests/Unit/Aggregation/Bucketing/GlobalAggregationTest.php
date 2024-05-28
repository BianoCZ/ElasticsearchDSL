<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\GlobalAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;
use stdClass;
use function json_encode;

class GlobalAggregationTest extends TestCase
{

    /**
     * Data provider for testToArray().
     */
    public function getToArrayData(): array
    {
        $out = [];

        // Case #0 global aggregation.
        $aggregation = new GlobalAggregation('test_agg');

        $result = [
            'global' => new stdClass(),
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #1 nested global aggregation.
        $aggregation = new GlobalAggregation('test_agg');
        $aggregation2 = new GlobalAggregation('test_agg_2');
        $aggregation->addAggregation($aggregation2);

        $result = [
            'global' => new stdClass(),
            'aggregations' => [
                $aggregation2->getName() => $aggregation2->toArray(),
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        return $out;
    }

    /**
     * Test for global aggregation toArray() method.
     *
     * @dataProvider getToArrayData
     */
    public function testToArray(GlobalAggregation $aggregation, array $expectedResult): void
    {
        $this->assertEquals(
            json_encode($expectedResult),
            json_encode($aggregation->toArray()),
        );
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
