<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit\SearchEndpoint;

use Biano\ElasticsearchDSL\SearchEndpoint\SortEndpoint;
use Biano\ElasticsearchDSL\Sort\FieldSort;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function assert;

class SortEndpointTest extends TestCase
{

    public function testItCanBeInstantiated(): void
    {
        $this->assertInstanceOf(SortEndpoint::class, new SortEndpoint());
    }

    /**
     * Tests endpoint normalization.
     */
    public function testNormalize(): void
    {
        $instance = new SortEndpoint();

        $normalizerInterface = $this->getMockForAbstractClass(
            NormalizerInterface::class,
        );
        assert($normalizerInterface instanceof NormalizerInterface || $normalizerInterface instanceof MockObject);

        $sort = new FieldSort('acme', ['order' => FieldSort::ASC]);
        $instance->add($sort);

        $this->assertEquals(
            [$sort->toArray()],
            $instance->normalize($normalizerInterface),
        );
    }

    /**
     * Tests if endpoint returns builders.
     */
    public function testEndpointGetter(): void
    {
        $sortName = 'acme_sort';
        $sort = new FieldSort('acme');
        $endpoint = new SortEndpoint();
        $endpoint->add($sort, $sortName);
        $builders = $endpoint->getAll();

        $this->assertCount(1, $builders);
        $this->assertSame($sort, $builders[$sortName]);
    }

}
