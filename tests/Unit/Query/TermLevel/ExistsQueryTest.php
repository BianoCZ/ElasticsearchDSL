<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\ExistsQuery;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for ExistsQuery.
 */
class ExistsQueryTest extends TestCase
{

    /**
     * Tests toArray() method.
     */
    public function testToArray(): void
    {
        $query = new ExistsQuery('bar');
        $this->assertEquals(['exists' => ['field' => 'bar']], $query->toArray());
    }

}
