<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Unit;

use Biano\ElasticsearchDSL\ParametersTrait;
use PHPUnit\Framework\TestCase;
use function is_object;

class ParametersTraitTest extends TestCase
{

    public function testGetAndAddParameter(): void
    {
        $class = new class {

            use ParametersTrait;

        };

        self::assertTrue(is_object($class->addParameter('acme', 123)));
        self::assertEquals(123, $class->getParameter('acme'));

        $class->addParameter('bar', 321);

        self::assertEquals(321, $class->getParameter('bar'));
        self::assertTrue(is_object($class->removeParameter('acme')));
    }

}
