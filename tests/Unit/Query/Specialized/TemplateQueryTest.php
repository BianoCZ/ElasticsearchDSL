<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Query\Specialized;

use Biano\ElasticsearchDSL\Query\Specialized\TemplateQuery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Unit test for Template.
 */
class TemplateQueryTest extends TestCase
{

    /**
     * Tests toArray() method with inline.
     */
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
        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests toArray() method with file
     */
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
        $this->assertEquals($expected, $query->toArray());
    }

    /**
     * Tests toArray() exception
     */
    public function testToArrayException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $query = new TemplateQuery();
        $query->toArray();
    }

}
