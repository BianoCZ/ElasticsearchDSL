<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\AutoDateHistogramAggregation;
use PHPUnit\Framework\TestCase;

class AudoDateHistogramAggregationTest extends TestCase
{

    /**
     * Tests agg.
     */
    public function testAutoDateHistogramAggregationSetField(): void
    {
        // Case #0 terms aggregation.
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field');

        $result = [
            'auto_date_histogram' => ['field' => 'test_field'],
        ];

        $this->assertEquals($aggregation->toArray(), $result);
    }

    /**
     * Tests setSize method.
     */
    public function testAutoDateHistogramAggregationFormat(): void
    {
        $date = '2020-12-25';
        // Case #1
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field');
        $aggregation->addParameter('format', $date);

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'format' => $date,

            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);

        // Case #2
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'test_field', null, $date);

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'format' => $date,
            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);
    }

    /**
     * Tests buckets.
     */
    public function testAutoDateHistogramAggregationBuckets(): void
    {
        // Case #1
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'wrong_field');
        $aggregation->setField('test_field');

        $aggregation->addParameter('buckets', 5);

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'buckets' => 5,
            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);

        // Case #2
        $aggregation = new AutoDateHistogramAggregation('test_agg', 'wrong_field', 5);
        $aggregation->setField('test_field');

        $result = [
            'auto_date_histogram' => [
                'field' => 'test_field',
                'buckets' => 5,
            ],
        ];

        $this->assertEquals($aggregation->toArray(), $result);
    }

    /**
     * Tests getType method.
     */
    public function testAutoDateHistogramAggregationGetType(): void
    {
        $aggregation = new AutoDateHistogramAggregation('foo', 'bar');
        $result = $aggregation->getType();
        $this->assertEquals('auto_date_histogram', $result);
    }

}
