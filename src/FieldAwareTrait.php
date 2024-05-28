<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL;

trait FieldAwareTrait
{

    private string $field;

    public function getField(): mixed
    {
        return $this->field;
    }

    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

}
