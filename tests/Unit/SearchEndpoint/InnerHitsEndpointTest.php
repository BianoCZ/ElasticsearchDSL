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
        self::assertInstanceOf(InnerHitsEndpoint::class, new InnerHitsEndpoint());
    }

    public function testEndpointGetter(): void
    {
        $hitName = 'foo';
        $innerHit = $this->createMock(BuilderInterface::class);
        $endpoint = new InnerHitsEndpoint();
        $endpoint->add($innerHit, $hitName);
        $builders = $endpoint->getAll();

        self::assertCount(1, $builders);
        self::assertSame($innerHit, $builders[$hitName]);
    }

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

        self::assertEquals(
            $expected,
            $endpoint->normalize($normalizer),
        );
    }

}
