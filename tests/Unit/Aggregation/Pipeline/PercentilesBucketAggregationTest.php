<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\PercentilesBucketAggregation;
use PHPUnit\Framework\TestCase;

class PercentilesBucketAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new PercentilesBucketAggregation('acme', 'test');
        $aggregation->setPercents([25.0, 50.0, 75.0]);

        $expected = [
            'percentiles_bucket' => [
                'buckets_path' => 'test',
                'percents' => [25.0, 50.0, 75.0],
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
