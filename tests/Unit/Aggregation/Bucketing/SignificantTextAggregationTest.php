<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\SignificantTextAggregation;
use PHPUnit\Framework\TestCase;

class SignificantTextAggregationTest extends TestCase
{

    public function testSignificantTextAggregationGetType(): void
    {
        $aggregation = new SignificantTextAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('significant_text', $result);
    }

    public function testSignificantTermsAggregationGetArray(): void
    {
        $aggregation = new SignificantTextAggregation('foo', 'title');
        $aggregation->addAggregation(new AggregationMock('name'));

        $result = $aggregation->getArray();
        $expected = ['field' => 'title'];

        self::assertEquals($expected, $result);
    }

}
