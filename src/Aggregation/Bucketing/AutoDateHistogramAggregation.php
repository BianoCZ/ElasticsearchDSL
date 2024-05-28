<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-autodatehistogram-aggregation.html
 */
class AutoDateHistogramAggregation extends AbstractBucketingAggregation
{

    public function __construct(string $name, string $field, ?int $buckets = null, ?string $format = null)
    {
        parent::__construct($name);

        $this->setField($field);

        if ($buckets) {
            $this->addParameter('buckets', $buckets);
        }

        if ($format) {
            $this->addParameter('format', $format);
        }
    }

    public function getType(): string
    {
        return 'auto_date_histogram';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
            ],
        );
    }

}
