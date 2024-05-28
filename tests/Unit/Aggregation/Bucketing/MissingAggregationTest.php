<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class MissingAggregationTest extends TestCase
{

    /**
     * Test if exception is thrown when field is not set.
     */
    public function testIfExceptionIsThrown(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Missing aggregation must have a field set.');
        $agg = new MissingAggregation('test_agg');
        $agg->getArray();
    }

    /**
     * Test getArray method.
     */
    public function testMissingAggregationGetArray(): void
    {
        $aggregation = new MissingAggregation('foo');
        $aggregation->setField('bar');
        $result = $aggregation->getArray();
        $this->assertEquals('bar', $result['field']);
    }

    /**
     * Test getType method.
     */
    public function testMissingAggregationGetType(): void
    {
        $aggregation = new MissingAggregation('bar');
        $result = $aggregation->getType();
        $this->assertEquals('missing', $result);
    }

}
