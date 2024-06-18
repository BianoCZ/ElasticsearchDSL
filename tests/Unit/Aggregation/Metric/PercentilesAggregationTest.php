<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\PercentilesAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class PercentilesAggregationTest extends TestCase
{

    public function testPercentilesAggregationGetArrayException(): void
    {
        $this->expectExceptionMessage('Percentiles aggregation must have field or script set.');
        $this->expectException(LogicException::class);

        $aggregation = new PercentilesAggregation('bar');
        $aggregation->getArray();
    }

    public function testGetType(): void
    {
        $aggregation = new PercentilesAggregation('bar');

        self::assertEquals('percentiles', $aggregation->getType());
    }

    public function testGetArray(): void
    {
        $aggregation = new PercentilesAggregation('bar', 'fieldValue', [50, 70]);

        self::assertSame(
            [
                'percents' => [50, 70],
                'field' => 'fieldValue',
            ],
            $aggregation->getArray(),
        );
    }

}
