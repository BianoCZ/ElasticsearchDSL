<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Tests\Functional\Query;

use Biano\ElasticsearchDSL\Query\Compound\FunctionScoreQuery;
use Biano\ElasticsearchDSL\Query\MatchAllQuery;
use Biano\ElasticsearchDSL\Search;
use Biano\ElasticsearchDSL\Tests\Functional\AbstractElasticsearchTestCase;
use function count;

class FunctionScoreQueryTest extends AbstractElasticsearchTestCase
{

    /**
     * @inheritDoc
     */
    protected function getDataArray(): array
    {
        return [
            'product' => [
                [
                    'title' => 'acme',
                    'price' => 10,
                ],
                [
                    'title' => 'foo',
                    'price' => 20,
                ],
                [
                    'title' => 'bar',
                    'price' => 10,
                ],
            ],
        ];
    }

    /**
     * Match all test
     */
    public function testRandomScore(): void
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addRandomFunction();
        $fquery->addParameter('boost_mode', 'multiply');

        $search = new Search();
        $search->addQuery($fquery);
        $results = $this->executeSearch($search);

        $this->assertEquals(count($this->getDataArray()['product']), count($results));
    }

    public function testScriptScore(): void
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addScriptScoreFunction(
            "
            if (doc['price'].value < params.target) 
             {
               return doc['price'].value * params.charge; 
             }
             return doc['price'].value;
             ",
            [
                'target' => 10,
                'charge' => 0.9,
            ],
        );

        $search = new Search();
        $search->addQuery($fquery);
        $results = $this->executeSearch($search);

        foreach ($results as $document) {
            $this->assertLessThanOrEqual(20, $document['price']);
        }
    }

}
