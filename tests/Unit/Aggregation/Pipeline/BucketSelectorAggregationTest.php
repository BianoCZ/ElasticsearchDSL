<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\BucketSelectorAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class BucketSelectorAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new BucketSelectorAggregation(
            'test',
            [
                'my_var1' => 'foo',
                'my_var2' => 'bar',
            ],
        );
        $aggregation->setScript('foo > bar');

        $expected = [
            'bucket_selector' => [
                'buckets_path' => [
                    'my_var1' => 'foo',
                    'my_var2' => 'bar',
                ],
                'script' => 'foo > bar',
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('`test` aggregation must have script set.');

        $aggregation = new BucketSelectorAggregation('test', []);

        $aggregation->getArray();
    }

}
