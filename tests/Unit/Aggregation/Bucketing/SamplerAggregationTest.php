<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\SamplerAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;

class SamplerAggregationTest extends TestCase
{

    public function testGetType(): void
    {
        $aggregation = new SamplerAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('sampler', $result);
    }

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

        self::assertEquals($expected, $result);
    }

    public function testGetArrayNoShardSize(): void
    {
        $aggregation = new SamplerAggregation('foo', 'bar');

        self::assertEquals(['field' => 'bar'], $aggregation->getArray());
    }

}
