<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use Biano\ElasticsearchDSL\Query\Specialized\TemplateQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TemplateQueryTest extends TestCase
{

    public function testToArrayInline(): void
    {
        $inline = '"term": {"field": "{{query_string}}"}';
        $params = ['query_string' => 'all about search'];
        $query = new TemplateQuery(null, $inline, $params);
        $expected = [
            'template' => [
                'inline' => $inline,
                'params' => $params,
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

    public function testToArrayFile(): void
    {
        $file = 'my_template';
        $params = ['query_string' => 'all about search'];
        $query = new TemplateQuery();
        $query->setFile($file);
        $query->setParams($params);
        $expected = [
            'template' => [
                'file' => $file,
                'params' => $params,
            ],
        ];

        self::assertEquals($expected, $query->toArray());
    }

    public function testToArrayException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $query = new TemplateQuery();
        $query->toArray();
    }

}
