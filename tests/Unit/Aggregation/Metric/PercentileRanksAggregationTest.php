<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\PercentileRanksAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class PercentileRanksAggregationTest extends TestCase
{

    public PercentileRanksAggregation $agg;

    public function setUp(): void
    {
        $this->agg = new PercentileRanksAggregation('foo');
    }

    public function testIfPercentileRanksAggregationThrowsAnException(): void
    {
        $this->expectException(LogicException::class);

        $this->agg->toArray();
    }

    public function testIfExceptionIsThrownWhenFieldSetAndValueNotSet(): void
    {
        $this->expectException(LogicException::class);

        $this->agg->setField('bar');
        $this->agg->toArray();
    }

    public function testIfExceptionIsThrownWhenScriptSetAndValueNotSet(): void
    {
        $this->expectException(LogicException::class);

        $this->agg->setScript('bar');
        $this->agg->toArray();
    }

    public function testGetType(): void
    {
        self::assertEquals('percentile_ranks', $this->agg->getType());
    }

    public function testToArray(): void
    {
        $this->agg->setField('bar');
        $this->agg->setValues([15, 20]);

        self::assertSame(
            [
                'percentile_ranks' => [
                    'field' => 'bar',
                    'values' => [15, 20],
                ],
            ],
            $this->agg->toArray(),
        );
    }

}
