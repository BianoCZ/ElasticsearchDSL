<?php

declare(strict_types = 1);

namespace Biano\ElasticsearchDSL\Query\Specialized;

use Biano\ElasticsearchDSL\BuilderInterface;
use Biano\ElasticsearchDSL\ParametersTrait;
use InvalidArgumentException;
use function array_filter;

/**
 * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-template-query.html
 */
class TemplateQuery implements BuilderInterface
{

    use ParametersTrait;

    private ?string $file = null;

    private ?string $inline = null;

    /** @var array<mixed> */
    private array $params = [];

    /**
     * @param array<mixed> $params
     */
    public function __construct(?string $file = null, ?string $inline = null, array $params = [])
    {
        if ($file !== null) {
            $this->setFile($file);
        }

        if ($inline !== null) {
            $this->setInline($inline);
        }

        $this->setParams($params);
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getInline(): ?string
    {
        return $this->inline;
    }

    public function setInline(string $inline): self
    {
        $this->inline = $inline;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array<mixed> $params
     */
    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function getType(): string
    {
        return 'template';
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $output = array_filter(
            [
                'file' => $this->getFile(),
                'inline' => $this->getInline(),
                'params' => $this->getParams(),
            ],
        );

        if (!isset($output['file']) && !isset($output['inline'])) {
            throw new InvalidArgumentException(
                'Template query requires that either `inline` or `file` parameters are set',
            );
        }

        $output = $this->processArray($output);

        return [$this->getType() => $output];
    }

}
