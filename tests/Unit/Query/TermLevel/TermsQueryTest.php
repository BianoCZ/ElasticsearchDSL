<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use Biano\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use PHPUnit\Framework\TestCase;

class TermsQueryTest extends TestCase
{

    public function testToArray(): void
    {
        $query = new TermsQuery('user', ['bob', 'elasticsearch']);
        $expected = [
            'terms' => [
                'user' => ['bob', 'elasticsearch'],
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

}
