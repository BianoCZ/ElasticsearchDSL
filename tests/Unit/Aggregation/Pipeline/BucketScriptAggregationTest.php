<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\BucketScriptAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

class BucketScriptAggregationTest extends TestCase
{

    public function testToArray(): void
    {
        $aggregation = new BucketScriptAggregation(
            'test',
            [
                'my_var1' => 'foo',
                'my_var2' => 'bar',
            ],
        );
        $aggregation->setScript('test script');
        $aggregation->addParameter('gap_policy', 'insert_zeros');

        $expected = [
            'bucket_script' => [
                'buckets_path' => [
                    'my_var1' => 'foo',
                    'my_var2' => 'bar',
                ],
                'script' => 'test script',
                'gap_policy' => 'insert_zeros',
            ],
        ];

        self::assertEquals($expected, $aggregation->toArray());
    }

    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('`test` aggregation must have script set.');

        $aggregation = new BucketScriptAggregation('test', []);

        $aggregation->getArray();
    }

}
