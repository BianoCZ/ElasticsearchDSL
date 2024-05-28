<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Pipeline;

use Biano\ElasticsearchDSL\Aggregation\Pipeline\BucketSelectorAggregation;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for bucket selector pipeline aggregation.
 */
class BucketSelectorAggregationTest extends TestCase
{

    /**
     * Tests toArray method.
     */
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

        $this->assertEquals($expected, $aggregation->toArray());
    }

    /**
     * Tests if the exception is thrown in getArray method if no
     * buckets_path or script is set
     */
    public function testGetArrayException(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('`test` aggregation must have script set.');
        $agg = new BucketSelectorAggregation('test', []);

        $agg->getArray();
    }

}
