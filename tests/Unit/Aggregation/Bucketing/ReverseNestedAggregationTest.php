<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\ReverseNestedAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\TermsAggregation;
use PHPUnit\Framework\TestCase;
use stdClass;
use function json_encode;

class ReverseNestedAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new ReverseNestedAggregation('test_nested_agg');
        $aggregation->setPath('test_path');
        $aggregation->addAggregation($termAggregation);

        $expected = [
            'reverse_nested' => ['path' => 'test_path'],
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

    public function testToArrayNoPath(): void
    {
        $termAggregation = new TermsAggregation('acme');

        $aggregation = new ReverseNestedAggregation('test_nested_agg');
        $aggregation->addAggregation($termAggregation);

        $expected = [
            'reverse_nested' => new stdClass(),
            'aggregations' => [
                $termAggregation->getName() => $termAggregation->toArray(),
            ],
        ];

        self::assertEquals(
            json_encode($expected),
            json_encode($aggregation->toArray()),
        );
    }

}
