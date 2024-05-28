<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\InnerHit\NestedInnerHit;
use Biano\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class InnerHitsEndpointTest extends TestCase
{

    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(
            InnerHitsEndpoint::class,
            new InnerHitsEndpoint(),
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $hitName = 'foo';
        $innerHit = $this->getMockBuilder(BuilderInterface::class)->getMock();
        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, $hitName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($innerHit, $builders[$hitName]);
    }

    /**
     * Tests normalize method
     */
    public function testNormalization(): void
    {
        $normalizer = $this->createMock(NormalizerInterface::class);
        $innerHit = $this->createMock(NestedInnerHit::class);
        $innerHit->expects(self::any())->method('getName')->willReturn('foo');
        $innerHit->expects(self::any())->method('toArray')->willReturn(['foo' => 'bar']);

        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, 'foo');
        $expected = [
            'foo' => ['foo' => 'bar'],
        ];

        $this->assertEquals(
            $expected,
            $endpoint->normalize($normalizer),
        );
    }

}
