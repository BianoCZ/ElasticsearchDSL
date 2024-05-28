<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Highlight;

use Biano\ElasticsearchDSL\Highlight\Highlight;
use PHPUnit\Framework\TestCase;
use StdClass;

class HighlightTest extends TestCase
{

    /**
     * Tests GetType method, it should return 'highlight'.
     */
    public function testGetType(): void
    {
        $highlight = new Highlight();
        $result = $highlight->getType();
        $this->assertEquals('highlight', $result);
    }

    /**
     * Tests ParametersTrait hasParameter method.
     */
    public function testTraitHasParameter(): void
    {
        $highlight = new Highlight();
        $highlight->addParameter('_source', ['include' => ['title']]);
        $result = $highlight->hasParameter('_source');
        $this->assertTrue($result);
    }

    /**
     * Tests ParametersTrait removeParameter method.
     */
    public function testTraitRemoveParameter(): void
    {
        $highlight = new Highlight();
        $highlight->addParameter('_source', ['include' => ['title']]);
        $highlight->removeParameter('_source');
        $result = $highlight->hasParameter('_source');
        $this->assertFalse($result);
    }

    /**
     * Tests ParametersTrait getParameter method.
     */
    public function testTraitGetParameter(): void
    {
        $highlight = new Highlight();
        $highlight->addParameter('_source', ['include' => 'title']);
        $expectedResult = ['include' => 'title'];
        $this->assertEquals($expectedResult, $highlight->getParameter('_source'));
    }

    /**
     * Tests ParametersTrait getParameters and setParameters methods.
     */
    public function testTraitSetGetParameters(): void
    {
        $highlight = new Highlight();
        $highlight->setParameters(
            [
                '_source',
                ['include' => 'title'],
                'content',
                ['force_source' => true],
            ],
        );
        $expectedResult = [
            '_source',
            ['include' => 'title'],
            'content',
            ['force_source' => true],
        ];
        $this->assertEquals($expectedResult, $highlight->getParameters());
    }

    /**
     * Test toArray method.
     */
    public function testToArray(): void
    {
        $highlight = new Highlight();
        $highlight->addField('ok');
        $highlight->addParameter('_source', ['include' => ['title']]);
        $highlight->setTags(['<tag>'], ['</tag>']);
        $result = $highlight->toArray();
        $expectedResult = [
            'fields' => [
                'ok' => new stdClass(),
            ],
            '_source' => [
                'include' => ['title'],
            ],
            'pre_tags' => ['<tag>'],
            'post_tags' => ['</tag>'],
        ];
        $this->assertEquals($expectedResult, $result);
    }

}
