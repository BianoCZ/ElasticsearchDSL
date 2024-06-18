<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\NestedAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;

class NestedAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new NestedAggregation('test_nested_agg');
        $aggregation->setPath('test_path');
        $aggregation->addAggregation($termAggregation);

        $expected = [
            'nested' => ['path' => 'test_path'],
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
