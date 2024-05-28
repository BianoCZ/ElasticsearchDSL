<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\InnerHit;

class ParentInnerHit extends NestedInnerHit
{

    public function getType(): string
    {
        return 'parent';
    }

}
