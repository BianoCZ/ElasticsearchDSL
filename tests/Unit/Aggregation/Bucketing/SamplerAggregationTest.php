<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\SamplerAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class SamplerAggregationTest extends TestCase
{

    /**
     * Tests getType method.
     */
    public function testGetType(): void
    {
        $aggregation = new SamplerAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('sampler', $result);
    }

    /**
     * Tests toArray method.
     */
    public function testToArray(): void
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new SamplerAggregation('foo');
        $aggregation->addAggregation($termAggregation);
        $aggregation->setField('name');
        $aggregation->setShardSize(200);
        $result = $aggregation->toArray();
        $expected = [
            'sampler' => [
                'field' => 'name',
                'shard_size' => 200,
            ],
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests getArray method without provided shard size.
     */
    public function testGetArrayNoShardSize(): void
    {
        $aggregation = new SamplerAggregation('foo', 'bar');
        $this->assertEquals(['field' => 'bar'], $aggregation->getArray());
    }

}
