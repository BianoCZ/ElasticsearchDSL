<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Serializer\Normalizer;

/**
 * This should be implemented by normalizable object that required to be processed in specific order.
 */
interface OrderedNormalizerInterface
{

    /**
     * Returns normalization priority.
     */
    public function getOrder(): int;

}
