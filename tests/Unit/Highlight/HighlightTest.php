<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\Highlight;

use Biano\ElasticsearchDSL\Highlight\Highlight;
use PHPUnit\Framework\TestCase;
use StdClass;

class HighlightTest extends TestCase
{

    public function testGetType(): void
    {
        $highlight = new Highlight();

        $result = $highlight->getType();

        self::assertEquals('highlight', $result);
    }

    public function testTraitHasParameter(): void
    {
        $highlight = new Highlight();
        $highlight->addParameter('_source', ['include' => ['title']]);

        $result = $highlight->hasParameter('_source');

        self::assertTrue($result);
    }

    public function testTraitRemoveParameter(): void
    {
        $highlight = new Highlight();
        $highlight->addParameter('_source', ['include' => ['title']]);
        $highlight->removeParameter('_source');

        $result = $highlight->hasParameter('_source');

        self::assertFalse($result);
    }

    public function testTraitGetParameter(): void
    {
        $highlight = new Highlight();
        $highlight->addParameter('_source', ['include' => 'title']);

        $expected = ['include' => 'title'];

        self::assertEquals($expected, $highlight->getParameter('_source'));
    }

    public function testTraitSetGetParameters(): void
    {
        $highlight = new Highlight();
        $highlight->setParameters(
            [
                '_source' => ['include' => 'title'],
                'content' => ['force_source' => true],
            ],
        );
        $expected = [
            '_source' => ['include' => 'title'],
            'content' => ['force_source' => true],
        ];

        self::assertEquals($expected, $highlight->getParameters());
    }

    public function testToArray(): void
    {
        $highlight = new Highlight();
        $highlight->addField('ok');
        $highlight->addParameter('_source', ['include' => ['title']]);
        $highlight->setTags(['<tag>'], ['</tag>']);

        $result = $highlight->toArray();
        $expected = [
            'fields' => [
                'ok' => new stdClass(),
            ],
            '_source' => [
                'include' => ['title'],
            ],
            'pre_tags' => ['<tag>'],
            'post_tags' => ['</tag>'],
        ];

        self::assertEquals($expected, $result);
    }

}
