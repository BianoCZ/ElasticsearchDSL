<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL;

interface NamedBuilderInterface extends BuilderInterface
{

    /**
     * Returns element name.
     */
    public function getName(): string;

}
