<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\RangeAggregation;
use PHPUnit\Framework\TestCase;

class RangeAggregationTest extends TestCase
{

    /**
     * Test addRange method.
     */
    public function testRangeAggregationAddRange(): void
    {
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->addRange('10', 20);

        $result = [
            'range' => [
                'field' => 'test_field',
                'ranges' => [
                    [
                        'from' => '10',
                        'to' => 20,
                    ],
                ],
                'keyed' => false,
            ],
        ];

        $this->assertEquals($result, $aggregation->toArray());
    }

    /**
     * Test addRange method with multiple values.
     */
    public function testRangeAggregationAddRangeMultiple(): void
    {
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->setKeyed(true);
        $aggregation->addRange('10', null, 'range_1');
        $aggregation->addRange(null, '20', 'range_2');

        $result = [
            'range' => [
                'field' => 'test_field',
                'ranges' => [
                    [
                        'from' => '10',
                        'key' => 'range_1',
                    ],
                    [
                        'to' => '20',
                        'key' => 'range_2',
                    ],
                ],
                'keyed' => true,
            ],
        ];

        $this->assertEquals($result, $aggregation->toArray());
    }

    /**
     * Test addRange method with nested values.
     */
    public function testRangeAggregationAddRangeNested(): void
    {
        $aggregation = new RangeAggregation('test_agg');
        $aggregation->setField('test_field');
        $aggregation->addRange('10', '10');

        $aggregation2 = new RangeAggregation('test_agg_2');
        $aggregation2->addRange('20', '20');

        $aggregation->addAggregation($aggregation2);

        $result = [
            'range' => [
                'field' => 'test_field',
                'ranges' => [
                    [
                        'from' => '10',
                        'to' => '10',
                    ],
                ],
                'keyed' => false,
            ],
            'aggregations' => [
                'test_agg_2' => [
                    'range' => [
                        'ranges' => [
                            [
                                'from' => '20',
                                'to' => '20',
                            ],
                        ],
                        'keyed' => false,
                    ],
                ],
            ],
        ];

        $this->assertEquals($result, $aggregation->toArray());
    }

    /**
     * Tests getType method.
     */
    public function testRangeAggregationGetType(): void
    {
        $agg = new RangeAggregation('foo');
        $result = $agg->getType();
        $this->assertEquals('range', $result);
    }

    /**
     * Tests removeRangeByKey method.
     */
    public function testRangeAggregationRemoveRangeByKey(): void
    {
        $aggregation = new RangeAggregation('foo');
        $aggregation->setField('price');
        $aggregation->setKeyed(true);
        $aggregation->addRange(100, 300, 'name');

        $expected = [
            'field' => 'price',
            'keyed' => true,
            'ranges' => [
                [
                    'from' => 100,
                    'to' => 300,
                    'key' => 'name',
                ],
            ],
        ];

        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected, 'get array of ranges when keyed=true');

        $result = $aggregation->removeRangeByKey('name');
        $this->assertTrue($result, 'returns true when removed valid range name');

        $result = $aggregation->removeRangeByKey('not_existing_key');
        $this->assertFalse($result, 'should not allow remove not existing key if keyed=true');

        $aggregation->setKeyed(false);
        $result = $aggregation->removeRangeByKey('not_existing_key');
        $this->assertFalse($result, 'should not allow remove not existing key if keyed=false');

        $aggregation->addRange(100, 300, 'name');
        $result = $aggregation->removeRangeByKey('name');
        $this->assertFalse($result, 'can not remove any existing range if keyed=false');
    }

    /**
     * Tests removeRange method.
     */
    public function testRangeAggregationRemoveRange(): void
    {
        $aggregation = new RangeAggregation('foo');
        $aggregation->setField('price');
        $aggregation->setKeyed(true);
        $aggregation->addRange(100, 300, 'key');
        $aggregation->addRange(500, 700, 'range_2');

        $expected = [
            'field' => 'price',
            'keyed' => true,
            'ranges' => [
                [
                    'from' => 100,
                    'to' => 300,
                    'key' => 'key',
                ],
            ],
        ];

        $aggregation->removeRange(500, 700);
        $result = $aggregation->getArray();
        $this->assertEquals($result, $expected, 'get expected array of ranges');
        $result = $aggregation->removeRange(500, 700);
        $this->assertFalse($result, 'returns false after removing not-existing range');
    }

    /**
     * Tests if parameter can be passed to constructor.
     */
    public function testConstructor(): void
    {
        $aggregation = new RangeAggregation('foo', 'fieldValue', [['from' => 'now', 'key' => 'nowkey']], true);
        $this->assertSame(
            [
                'range' => [
                    'keyed' => true,
                    'ranges' => [
                        [
                            'from' => 'now',
                            'key' => 'nowkey',
                        ],
                    ],
                    'field' => 'fieldValue',
                ],
            ],
            $aggregation->toArray(),
        );
    }

}
