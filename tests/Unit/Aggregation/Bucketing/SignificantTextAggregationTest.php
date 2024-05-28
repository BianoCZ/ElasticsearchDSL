<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\AbstractAggregation;
use Biano\ElasticsearchDSL\Aggregation\Bucketing\SignificantTextAggregation;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for children aggregation.
 */
class SignificantTextAggregationTest extends TestCase
{

    /**
     * Tests getType method.
     */
    public function testSignificantTextAggregationGetType(): void
    {
        $aggregation = new SignificantTextAggregation('foo');
        $result = $aggregation->getType();
        $this->assertEquals('significant_text', $result);
    }

    /**
     * Tests getArray method.
     */
    public function testSignificantTermsAggregationGetArray(): void
    {
        $mock = $this->getMockBuilder(AbstractAggregation::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $mock->setName('name');
        $aggregation = new SignificantTextAggregation('foo', 'title');
        $aggregation->addAggregation($mock);
        $result = $aggregation->getArray();
        $expected = ['field' => 'title'];
        $this->assertEquals($expected, $result);
    }

}
