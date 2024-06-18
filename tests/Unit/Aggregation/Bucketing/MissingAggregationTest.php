<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\MissingAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class MissingAggregationTest extends TestCase
{

    public function testIfExceptionIsThrown(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Missing aggregation must have a field set.');

        $aggregation = new MissingAggregation('test_agg');
        $aggregation->getArray();
    }

    public function testMissingAggregationGetArray(): void
    {
        $aggregation = new MissingAggregation('foo');
        $aggregation->setField('bar');

        $result = $aggregation->getArray();

        self::assertEquals('bar', $result['field']);
    }

    public function testMissingAggregationGetType(): void
    {
        $aggregation = new MissingAggregation('bar');

        $result = $aggregation->getType();

        self::assertEquals('missing', $result);
    }

}
