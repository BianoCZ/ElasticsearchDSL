<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Span;

use Biano\ElasticsearchDSL\ParametersTrait;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-span-containing-query.html
 */
class SpanContainingQuery implements SpanQueryInterface
{

    use ParametersTrait;

    private SpanQueryInterface $little;

    private SpanQueryInterface $big;

    public function __construct(SpanQueryInterface $little, SpanQueryInterface $big)
    {
        $this->setLittle($little);
        $this->setBig($big);
    }

    public function getLittle(): SpanQueryInterface
    {
        return $this->little;
    }

    public function setLittle(SpanQueryInterface $little): self
    {
        $this->little = $little;

        return $this;
    }

    public function getBig(): SpanQueryInterface
    {
        return $this->big;
    }

    public function setBig(SpanQueryInterface $big): self
    {
        $this->big = $big;

        return $this;
    }

    public function getType(): string
    {
        return 'span_containing';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $output = [
            'little' => $this->getLittle()->toArray(),
            'big' => $this->getBig()->toArray(),
        ];

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }

}
