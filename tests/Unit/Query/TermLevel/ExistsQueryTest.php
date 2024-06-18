<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\ExistsQuery;
use PHPUnit\Framework\TestCase;

class ExistsQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new ExistsQuery('bar');

        self::assertEquals(['exists' => ['field' => 'bar']], $query->toArray());
    }

}
