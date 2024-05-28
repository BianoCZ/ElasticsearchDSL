<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Aggregation\Bucketing;

use LogicException;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-datehistogram-aggregation.html
 */
class DateHistogramAggregation extends AbstractBucketingAggregation
{

    private ?string $calendarInterval = null;

    private ?string $fixedInterval = null;

    private ?string $format = null;

    public function __construct(string $name, ?string $field = null, ?string $interval = null, ?string $format = null)
    {
        parent::__construct($name);

        if ($field !== null) {
            $this->setField($field);
        }

        if ($interval !== null) {
            $this->setCalendarInterval($interval);
        }

        if ($format !== null) {
            $this->setFormat($format);
        }
    }

    public function getFixedInterval(): ?string
    {
        return $this->fixedInterval;
    }

    public function setFixedInterval(string $interval): self
    {
        $this->fixedInterval = $interval;

        return $this;
    }

    public function getCalendarInterval(): ?string
    {
        return $this->calendarInterval;
    }

    public function setCalendarInterval(string $interval): self
    {
        $this->calendarInterval = $interval;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getType(): string
    {
        return 'date_histogram';
    }

    /**
     * @inheritDoc
     */
    public function getArray(): array
    {
        if ($this->getField() === null || ($this->getCalendarInterval() === null && $this->getFixedInterval() === null)) {
            throw new LogicException('Date histogram aggregation must have field and interval set.');
        }

        $data = [
            'field' => $this->getField(),
        ];

        if ($this->getCalendarInterval() !== null) {
            $data['calendar_interval'] = $this->getCalendarInterval();
        } elseif ($this->getFixedInterval() !== null) {
            $data['fixed_interval'] = $this->getFixedInterval();
        }

        if ($this->getFormat() !== null) {
            $data['format'] = $this->getFormat();
        }

        return $data;
    }

}
