<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\SearchEndpoint;

/**
 * Factory for search endpoints.
 */
class SearchEndpointFactory
{
    /**
     * @var array Holds namespaces for endpoints.
     */
    private static $endpoints = [
        'query' => \ONGR\ElasticsearchDSL\SearchEndpoint\QueryEndpoint::class,
        'post_filter' => \ONGR\ElasticsearchDSL\SearchEndpoint\PostFilterEndpoint::class,
        'sort' => \ONGR\ElasticsearchDSL\SearchEndpoint\SortEndpoint::class,
        'highlight' => \ONGR\ElasticsearchDSL\SearchEndpoint\HighlightEndpoint::class,
        'aggregations' => \ONGR\ElasticsearchDSL\SearchEndpoint\AggregationsEndpoint::class,
        'suggest' => \ONGR\ElasticsearchDSL\SearchEndpoint\SuggestEndpoint::class,
        'inner_hits' => \ONGR\ElasticsearchDSL\SearchEndpoint\InnerHitsEndpoint::class,
    ];

    /**
     * Returns a search endpoint instance.
     *
     * @param string $type Type of endpoint.
     *
     * @return SearchEndpointInterface
     *
     * @throws \RuntimeException Endpoint does not exist.
     */
    public static function get($type)
    {
        if (!array_key_exists($type, self::$endpoints)) {
            throw new \RuntimeException('Endpoint does not exist.');
        }

        return new self::$endpoints[$type]();
    }
}
