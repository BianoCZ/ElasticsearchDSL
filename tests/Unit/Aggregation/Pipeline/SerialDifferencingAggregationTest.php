<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\SerialDifferencingAggregation;
use PHPUnit\Framework\TestCase;

class SerialDifferencingAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new SerialDifferencingAggregation('acme', 'test');
        $aggregation->addParameter('lag', '7');

        $expected = [
            'serial_diff' => [
                'buckets_path' => 'test',
                'lag' => '7',
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
