<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use Biano\ElasticsearchDSL\Highlight\Highlight;
use Biano\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function assert;
use function json_encode;

class HighlightEndpointTest extends TestCase
{

    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(HighlightEndpoint::class, new HighlightEndpoint());
    }

    /**
     * Tests adding builder.
     */
    public function testNormalization(): void
    {
        $instance = new HighlightEndpoint();
        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class,
        );
        assert($normalizerInterface instanceof NormalizerInterface || $normalizerInterface instanceof MockObject);

        $this->assertFalse($instance->normalize($normalizerInterface));

        $highlight = new Highlight();
        $highlight->addField('acme');
        $instance->add($highlight);

        $this->assertEquals(
            json_encode($highlight->toArray()),
            json_encode($instance->normalize($normalizerInterface)),
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $highlightName = 'acme_highlight';
        $highlight = new Highlight();
        $highlight->addField('acme');

        $endpoint = new HighlightEndpoint();
        $endpoint->add($highlight, $highlightName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($highlight, $builders[$highlightName]);
    }

}
