<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Aggregation\Bucketing;

use Biano\ElasticsearchDSL\Aggregation\Bucketing\SignificantTermsAggregation;
use PHPUnit\Framework\TestCase;

class SignificantTermsAggregationTest extends TestCase
{

    public function testSignificantTermsAggregationGetType(): void
    {
        $aggregation = new SignificantTermsAggregation('foo');

        $result = $aggregation->getType();

        self::assertEquals('significant_terms', $result);
    }

    public function testSignificantTermsAggregationGetArray(): void
    {
        $aggregation = new SignificantTermsAggregation('foo', 'title');
        $aggregation->addAggregation(new AggregationMock('name'));

        $result = $aggregation->getArray();
        $expected = ['field' => 'title'];

        self::assertEquals($expected, $result);
    }

}
