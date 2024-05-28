<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit;

use Biano\ElasticsearchDSL\BuilderBag;
use Biano\ElasticsearchDSL\BuilderInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BuilderBagTest extends TestCase
{

    /**
     * Tests if bag knows if he has a builder.
     */
    public function testHas(): void
    {
        $bag = new BuilderBag();
        $fooBuilder = $this->getBuilder('foo');
        $builderName = $bag->add($fooBuilder);
        $this->assertTrue($bag->has($builderName));
    }

    /**
     * Tests if bag can remove a builder.
     */
    public function testRemove(): void
    {
        $bag = new BuilderBag();
        $fooBuilder = $this->getBuilder('foo');
        $acmeBuilder = $this->getBuilder('acme');
        $fooBuilderName = $bag->add($fooBuilder);
        $acmeBuilderName = $bag->add($acmeBuilder);

        $bag->remove($fooBuilderName);

        $this->assertFalse($bag->has($fooBuilderName), 'Foo builder should not exist anymore.');
        $this->assertTrue($bag->has($acmeBuilderName), 'Acme builder should exist.');
        $this->assertCount(1, $bag->all());
    }

    /**
     * Tests if bag can clear it's builders.
     */
    public function testClear(): void
    {
        $bag = new BuilderBag(
            [
                $this->getBuilder('foo'),
                $this->getBuilder('baz'),
            ],
        );

        $bag->clear();

        $this->assertEmpty($bag->all());
    }

    /**
     * Tests if bag can get a builder.
     */
    public function testGet(): void
    {
        $bag = new BuilderBag();
        $bazBuilder = $this->getBuilder('baz');
        $builderName = $bag->add($bazBuilder);

        $this->assertNotEmpty($bag->get($builderName));
    }

    /**
     * Returns builder.
     */
    private function getBuilder(string $name): MockObject|BuilderInterface
    {
        $friendlyBuilderMock = $this->getMockBuilder(BuilderInterface::class)
            ->setMethods(['getName', 'toArray', 'getType'])
            ->disableOriginalConstructor()
            ->getMock();

        $friendlyBuilderMock
            ->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($name));

        $friendlyBuilderMock
            ->expects($this->any())
            ->method('toArray')
            ->will($this->returnValue([]));

        return $friendlyBuilderMock;
    }

}
