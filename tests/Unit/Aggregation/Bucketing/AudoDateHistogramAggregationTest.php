<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\AutoDateHistogramAggregation;
use PHPUnit\Framework\TestCase;

class AudoDateHistogramAggregationTest extends TestCase
{

    public function testAutoDateHistogramAggregationSetField(): void
    {
        // Case #0 terms aggregation.
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field');

        $result = $aggregation->toArray();
        $expected = [
            'auto_date_histogram' => ['field' => 'test_field'],
        ];

        self::assertEquals($expected, $result);
    }

    public function testAutoDateHistogramAggregationFormat(): void
    {
        $date = '2020-12-25';
        // Case #1
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field');
        $aggregation->addParameter('format', $date);

        $result = $aggregation->toArray();
        $expected = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'format' => $date,

            ],
        ];

        self::assertEquals($expected, $result);

        // Case #2
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field', null, $date);

        $result = $aggregation->toArray();
        $expected = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'format' => $date,
            ],
        ];

        self::assertEquals($expected, $result);
    }

    public function testAutoDateHistogramAggregationBuckets(): void
    {
        // Case #1
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'wrong_field');
        $aggregation->setField('test_field');

        $aggregation->addParameter('buckets', 5);

        $result = $aggregation->toArray();
        $expected = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'buckets' => 5,
            ],
        ];

        self::assertEquals($expected, $result);

        // Case #2
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'wrong_field', 5);
        $aggregation->setField('test_field');

        $result = $aggregation->toArray();
        $expected = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'buckets' => 5,
            ],
        ];

        self::assertEquals($expected, $result);
    }

    public function testAutoDateHistogramAggregationGetType(): void
    {
        $aggregation = new AutoDateHistogramAggregation('foo', 'bar');

        $result = $aggregation->getType();

        self::assertEquals('auto_date_histogram', $result);
    }

}
