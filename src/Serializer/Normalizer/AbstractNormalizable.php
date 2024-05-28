<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Serializer\Normalizer;

use Biano\ElasticsearchDSL\ParametersTrait;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * Custom abstract normalizer which can save references for other objects.
 */
abstract class AbstractNormalizable implements NormalizableInterface
{

    use ParametersTrait {
        ParametersTrait::hasParameter as hasReference;
        ParametersTrait::getParameter as getReference;
        ParametersTrait::getParameters as getReferences;
        ParametersTrait::addParameter as addReference;
        ParametersTrait::removeParameter as removeReference;
        ParametersTrait::setParameters as setReferences;
    }

}
