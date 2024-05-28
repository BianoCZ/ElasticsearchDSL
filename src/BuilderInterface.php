<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL;

interface BuilderInterface
{

    /**
     * Generates array which will be passed to elasticsearch-php client.
     *
     * @return array<mixed>
     */
    public function toArray(): array;

    /**
     * Returns element type.
     */
    public function getType(): string;

}
