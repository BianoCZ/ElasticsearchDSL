<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Metric;

use Biano\ElasticsearchDSL\Aggregation\Metric\CardinalityAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class CardinalityAggregationTest extends TestCase
{

    public function testGetArray(): void
    {
        $aggregation = new CardinalityAggregation('bar');

        $aggregation->setScript('foo');

        $result = $aggregation->getArray();

        self::assertArrayHasKey('script', $result, 'key=script when script is set');
        self::assertEquals('foo', $result['script'], 'script=foo when scripts name=foo');

        $aggregation->setField('foo');

        $result = $aggregation->getArray();

        self::assertArrayHasKey('field', $result, 'key=field when field is set');
        self::assertEquals('foo', $result['field'], 'field=foo when fields name=foo');

        $aggregation->setPrecisionThreshold(10);

        $result = $aggregation->getArray();

        self::assertArrayHasKey('precision_threshold', $result, 'key=precision_threshold when is set');
        self::assertEquals(10, $result['precision_threshold'], 'precision_threshold=10 when is set');

        $aggregation->setRehash(true);

        $result = $aggregation->getArray();

        self::assertArrayHasKey('rehash', $result, 'key=rehash when rehash is set');
        self::assertEquals(true, $result['rehash'], 'rehash=true when rehash is set to true');
    }

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Cardinality aggregation must have field or script set.');

        $aggregation = new CardinalityAggregation('bar');
        $aggregation->getArray();
    }

    public function testCardinallyAggregationGetType(): void
    {
        $aggregation = new CardinalityAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('cardinality', $result);
    }

}
