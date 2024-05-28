<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\TypeQuery;
use PHPUnit\Framework\TestCase;

class TypeQueryTest extends TestCase
{

    /**
     * Test for query toArray() method.
     */
    public function testToArray(): void
    {
        $query = new TypeQuery('foo');
        $expectedResult = [
            'type' => ['value' => 'foo'],
        ];

        $this->assertEquals($expectedResult, $query->toArray());
    }

}
