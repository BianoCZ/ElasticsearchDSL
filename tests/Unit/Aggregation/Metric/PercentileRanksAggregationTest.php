<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\PercentileRanksAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Percentile ranks aggregation unit tests.
 */
class PercentileRanksAggregationTest extends TestCase
{

    public PercentileRanksAggregation $agg;

    /**
     * Phpunit setup.
     */
    public function setUp(): void
    {
        $this->agg = new PercentileRanksAggregation('foo');
    }

    /**
     * Tests if exception is thrown when required parameters not set.
     */
    public function testIfPercentileRanksAggregationThrowsAnException(): void
    {
        $this->expectException(LogicException::class);
        $this->agg->toArray();
    }

    /**
     * Tests exception when only field is set.
     */
    public function testIfExceptionIsThrownWhenFieldSetAndValueNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->agg->setField('bar');
        $this->agg->toArray();
    }

    /**
     * Tests exception when only value is set.
     */
    public function testIfExceptionIsThrownWhenScriptSetAndValueNotSet(): void
    {
        $this->expectException(LogicException::class);
        $this->agg->setScript('bar');
        $this->agg->toArray();
    }

    /**
     * Test getType method.
     */
    public function testGetType(): void
    {
        $this->assertEquals('percentile_ranks', $this->agg->getType());
    }

    /**
     * Test toArray method.
     */
    public function testToArray(): void
    {
        $this->agg->setField('bar');
        $this->agg->setValues(['bar']);
        $this->assertSame(
            [
                'percentile_ranks' => [
                    'field' => 'bar',
                    'values' => ['bar'],
                ],
            ],
            $this->agg->toArray(),
        );
    }

}
