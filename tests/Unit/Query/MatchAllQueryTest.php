<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query;

use Biano\ElasticsearchDSL\Query\MatchAllQuery;
use PHPUnit\Framework\TestCase;
use stdClass;

class MatchAllQueryTest extends TestCase
{

    /**
     * Tests toArray().
     */
    public function testToArrayWhenThereAreNoParams(): void
    {
        $query = new MatchAllQuery();
        $this->assertEquals(['match_all' => new stdClass()], $query->toArray());
    }

    /**
     * Tests toArray().
     */
    public function testToArrayWithParams(): void
    {
        $params = ['boost' => 5];
        $query = new MatchAllQuery($params);
        $this->assertEquals(['match_all' => $params], $query->toArray());
    }

}
