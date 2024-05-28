<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Functional\Query;

use Biano\ElasticsearchDSL\Query\MatchAllQuery;
use Biano\ElasticsearchDSL\Search;
use Biano\ElasticsearchDSL\Tests\Functional\AbstractElasticsearchTestCase;

class MatchAllQueryTest extends AbstractElasticsearchTestCase
{

    /**
     * @inheritDoc
     */
    protected function getDataArray(): array
    {
        return [
            'product' => [
                ['title' => 'acme'],
                ['title' => 'foo'],
            ],
        ];
    }

    /**
     * Match all test
     */
    public function testMatchAll(): void
    {
        $search = new Search();
        $matchAll = new MatchAllQuery();

        $search->addQuery($matchAll);
        $q = $search->getQueries();
        $results = $this->executeSearch($search);

        $this->assertEquals($this->getDataArray()['product'], $results);
    }

}
