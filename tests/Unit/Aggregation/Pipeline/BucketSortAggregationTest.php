<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\BucketSortAggregation;
use Biano\ElasticsearchDSL\Sort\FieldSort;
use PHPUnit\Framework\TestCase;

class BucketSortAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new BucketSortAggregation('acme', 'test');

        $expected = [
            'bucket_sort' => ['buckets_path' => 'test'],
        ];

        self::assertEquals($expected, $aggregation->toArray());

        $aggregation = new BucketSortAggregation('acme');

        $expected = [
            'bucket_sort' => [],
        ];

        self::assertEquals($expected, $aggregation->toArray());

        $aggregation = new BucketSortAggregation('acme');
        $sort = new FieldSort('test_field', FieldSort::ASC);
        $aggregation->addSort($sort);

        $expected = [
            'bucket_sort' => [
                'sort' => [
                    [
                        'test_field' => ['order' => 'asc'],
                    ],
                ],
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());

        $aggregation = new BucketSortAggregation('acme');
        $sort = new FieldSort('test_field', FieldSort::ASC);
        $aggregation->addSort($sort);
        $aggregation->setSize(10);
        $aggregation->setFrom(50);

        $expected = [
            'bucket_sort' => [
                'sort' => [
                    [
                        'test_field' => ['order' => 'asc'],
                    ],
                ],
                'size' => 10,
                'from' => 50,
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

}
